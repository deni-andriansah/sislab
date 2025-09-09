<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\anggota;
use App\Models\Ruangan;
use App\Models\pm_Barang;
use App\Models\peminjaman_detail;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PmBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan daftar peminjaman
    public function index()
    {
        $pm_barang = pm_Barang::with('anggota', 'ruangan', 'peminjaman_details.barang')->get();
        $anggota = Anggota::all(); // Pastikan model Anggota ada
        $barang = Barang::all(); // Jika barang juga dibutuhkan
        $ruangan = Ruangan::all(); // Jika ruangan juga dibutuhkan

        return view('pm_barang.index', compact('pm_barang', 'anggota', 'barang', 'ruangan'));
    }

    // Menampilkan form untuk membuat peminjaman baru
    public function create()
    {
        $barang = Barang::all();
        $ruangan = Ruangan::all();
        $anggota = Anggota::all();
        return view('pm_barang.create', compact('barang', 'ruangan', 'anggota'));
    }

    // Menyimpan peminjaman baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'jenis_kegiatan' => 'required',
            'id_barang' => 'required|array',
            'jumlah_pinjam' => 'required|array',
            'jumlah_pinjam.*' => 'integer|min:1',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'waktu_peminjaman' => 'required',
            'nim' => 'required', // Pastikan NIM dikirim
        ]);

        // CARI id_anggota DARI NIM
        $anggota = Anggota::where('nim', $request->nim)->first();
        if (!$anggota) {
            return redirect()->back()->with('error', 'NIM tidak ditemukan!');
        }

        // Generate kode peminjaman
        $codePeminjaman = 'PM-' . date('Ymd') . '-' . mt_rand(1000, 9999);

        // Mengecek stok barang sebelum menyimpan peminjaman
        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);

            // Cek apakah stok cukup
            if ($barang->jumlah < $request->jumlah_pinjam[$index]) {
                Alert::error('Stok Tidak Cukup', 'Stok barang "' . $barang->nama_barang . '" hanya tersedia ' . $barang->jumlah . ' unit')->autoClose(3000);
                return redirect()->back()->withInput();
            }
        }

        // Simpan data peminjaman utama
        $pm_barang = new pm_barang();
        $pm_barang->code_peminjaman = $codePeminjaman;
        $pm_barang->id_anggota = $anggota->id; // Menggunakan ID anggota hasil pencarian NIM
        $pm_barang->jenis_kegiatan = $request->jenis_kegiatan;
        $pm_barang->id_ruangan = $request->id_ruangan;
        $pm_barang->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_barang->tanggal_pengembalian = $request->tanggal_pengembalian;
        $pm_barang->waktu_peminjaman = $request->waktu_peminjaman;
        $pm_barang->save();

        // Simpan detail peminjaman dan kurangi stok barang
        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);

            // Kurangi stok barang
            $barang->jumlah -= $request->jumlah_pinjam[$index];
            $barang->save();

            // Simpan detail peminjaman barang
            $peminjaman_detail = new peminjaman_detail();
            $peminjaman_detail->id_pm_Barang = $pm_barang->id;
            $peminjaman_detail->id_barang = $id_barang;
            $peminjaman_detail->jumlah_pinjam = $request->jumlah_pinjam[$index];
            $peminjaman_detail->save();
        }

        // Setelah data berhasil disimpan, alihkan ke halaman index
        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        return redirect()->route('pm_barang.index');
    }

    // Menampilkan form untuk mengedit peminjaman
    public function edit($id)
    {
        // Ambil data peminjaman berdasarkan code_peminjaman
        $pm_barang = pm_barang::where('code_peminjaman', $id)->first();
        if (!$pm_barang) {
            return redirect()->route('pm_barang.index')->with('error', 'Data peminjaman tidak ditemukan');
        }

        // Ambil detail barang yang dipinjam
        $details = peminjaman_detail::where('id_pm_barang', $pm_barang->id)->get();
        $barang = Barang::all();
        $ruangan = Ruangan::all();
        $anggota = Anggota::all();

        return view('pm_barang.edit', compact('pm_barang', 'details', 'barang', 'ruangan', 'anggota'));
    }

    // Mengupdate data peminjaman
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_anggota' => 'required|exists:anggotas,id',
            'jenis_kegiatan' => 'required',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'waktu_peminjaman' => 'required',
            'id_barang' => 'required|array|min:1',
            'jumlah_pinjam' => 'required|array|min:1',
            'jumlah_pinjam.*' => 'integer|min:1',
        ]);

        // Ambil data peminjaman
        $pm_barang = pm_barang::where('code_peminjaman', $id)->firstOrFail();

        // Kembalikan stok barang sebelumnya
        foreach ($pm_barang->peminjaman_details as $detail) {
            $barang = Barang::find($detail->id_barang);
            if ($barang) {
                $barang->jumlah += $detail->jumlah_pinjam;
                $barang->save();
            }
        }

        // Hapus semua detail lama
        peminjaman_detail::where('id_pm_barang', $pm_barang->id)->delete();

        // Update data utama
        $pm_barang->update([
            'id_anggota' => $request->id_anggota,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'waktu_peminjaman' => $request->waktu_peminjaman,
            'id_ruangan' => $request->id_ruangan,
        ]);

        // Tambah ulang detail baru dan cek stok barang
        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);

            // Cek apakah stok cukup
            if ($barang->jumlah < $request->jumlah_pinjam[$index]) {
                Alert::error('Stok Tidak Cukup', 'Stok barang "' . $barang->nama_barang . '" hanya tersedia ' . $barang->jumlah . ' unit')->autoClose(3000);
                return redirect()->back()->withInput();
            }

            // Kurangi stok barang
            $barang->jumlah -= $request->jumlah_pinjam[$index];
            $barang->save();

            // Simpan detail peminjaman baru
            peminjaman_detail::create([
                'id_pm_barang' => $pm_barang->id,
                'id_barang' => $id_barang,
                'jumlah_pinjam' => $request->jumlah_pinjam[$index],
            ]);
        }

        Alert::success('Success', 'Data berhasil diperbarui')->autoClose(1000);
        return redirect()->route('pm_barang.index');
    }

    // Menghapus peminjaman dan mengembalikan stok barang
    public function destroy($id)
    {
        $pm_barang = pm_barang::findOrFail($id);

        // Kembalikan stok barang
        foreach ($pm_barang->peminjaman_details as $detail) {
            $barang = Barang::findOrFail($detail->id_barang);
            $barang->jumlah += $detail->jumlah_pinjam;
            $barang->save();
        }

        // Hapus detail peminjaman
        peminjaman_detail::where('id_pm_barang', $pm_barang->id)->delete();

        // Hapus data peminjaman
        $pm_barang->delete();

        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('pm_barang.index');
    }

    // Fungsi untuk mencari anggota berdasarkan NIM
    public function cariAnggota(Request $request)
    {
        $nim = $request->nim;
        $anggota = Anggota::where('nim', $nim)->first();

        if ($anggota) {
            return response()->json(['success' => true, 'anggota' => $anggota]);
        } else {
            return response()->json(['success' => false, 'message' => 'NIM tidak ditemukan']);
        }
    }
}
