<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Ruangan;
use App\Models\pm_barang;
use App\Models\peminjaman_detail;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class PmBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $pm_barang = pm_barang::with('anggota', 'ruangan', 'peminjaman_details.barang')->get();
        $anggota = Anggota::all();
        $barang = Barang::all();
        $ruangan = Ruangan::all();

        return view('pm_barang.index', compact('pm_barang', 'anggota', 'barang', 'ruangan'));
    }


    public function create()
    {
        $barang = Barang::all();
        $ruangan = Ruangan::all();
        $anggota = Anggota::all();
        return view('pm_barang.create', compact('barang', 'ruangan', 'anggota'));
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'jenis_kegiatan' => 'required|string|max:255',
            'id_barang' => 'required|array|min:1',
            'id_barang.*' => 'required|exists:barangs,id',
            'jumlah_pinjam' => 'required|array|min:1',
            'jumlah_pinjam.*' => 'integer|min:1',
            'tanggal_peminjaman' => 'required|date|after_or_equal:today',
            'tanggal_pengembalian' => [
                'required',
                'date',
                'after:tanggal_peminjaman'
            ],
            'waktu_peminjaman' => 'required|date_format:H:i',
            'nim' => 'required|string',
            'id_ruangan' => 'required|exists:ruangans,id',
        ], [
            'tanggal_peminjaman.after_or_equal' => 'Tanggal peminjaman tidak boleh kurang dari hari ini',
            'tanggal_pengembalian.after' => 'Tanggal pengembalian harus lebih besar dari tanggal peminjaman',
            'id_barang.required' => 'Minimal pilih 1 barang untuk dipinjam',
            'jumlah_pinjam.*.min' => 'Jumlah pinjam minimal 1',
            'nim.required' => 'NIM wajib diisi',
            'id_ruangan.required' => 'Ruangan wajib dipilih',
        ]);

        // CARI id_anggota DARI NIM
        $anggota = Anggota::where('nim', $request->nim)->first();
        if (!$anggota) {
            Alert::error('Error', 'NIM tidak ditemukan dalam database!');
            return redirect()->back()->withInput();
        }

        // Generate kode peminjaman
        $codePeminjaman = 'PM-' . date('Ymd') . '-' . str_pad(pm_barang::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

        // Mengecek stok barang sebelum menyimpan peminjaman
        $barangErrors = [];
        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);

            // Cek apakah stok cukup
            if ($barang->jumlah < $request->jumlah_pinjam[$index]) {
                $barangErrors[] = 'Barang "' . $barang->nama_barang . '" stok hanya tersedia ' . $barang->jumlah . ' unit, diminta ' . $request->jumlah_pinjam[$index] . ' unit';
            }
        }

        // Jika ada error stok, tampilkan semua error
        if (!empty($barangErrors)) {
            $errorMessage = "Stok tidak mencukupi:\n" . implode("\n", $barangErrors);
            Alert::error('Stok Tidak Cukup', $errorMessage);
            return redirect()->back()->withInput();
        }

        // Simpan data peminjaman utama
        $pm_barang = new pm_barang();
        $pm_barang->code_peminjaman = $codePeminjaman;
        $pm_barang->id_anggota = $anggota->id;
        $pm_barang->jenis_kegiatan = $request->jenis_kegiatan;
        $pm_barang->id_ruangan = $request->id_ruangan;
        $pm_barang->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_barang->tanggal_pengembalian = $request->tanggal_pengembalian;
        $pm_barang->waktu_peminjaman = $request->waktu_peminjaman;
        $pm_barang->save();


        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);


            $barang->jumlah -= $request->jumlah_pinjam[$index];
            $barang->save();


            $peminjaman_detail = new peminjaman_detail();
            $peminjaman_detail->id_pm_barang = $pm_barang->id;
            $peminjaman_detail->id_barang = $id_barang;
            $peminjaman_detail->jumlah_pinjam = $request->jumlah_pinjam[$index];
            $peminjaman_detail->save();
        }


        Alert::success('Success', 'Peminjaman berhasil dibuat dengan kode: ' . $codePeminjaman)->autoClose(3000);
        return redirect()->route('pm_barang.index');
    }


    public function edit($id)
    {

        $pm_barang = pm_barang::where('code_peminjaman', $id)->first();
        if (!$pm_barang) {
            Alert::error('Error', 'Data peminjaman tidak ditemukan');
            return redirect()->route('pm_barang.index');
        }


        $details = peminjaman_detail::where('id_pm_barang', $pm_barang->id)->get();
        $barang = Barang::all();
        $ruangan = Ruangan::all();
        $anggota = Anggota::all();

        return view('pm_barang.edit', compact('pm_barang', 'details', 'barang', 'ruangan', 'anggota'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'id_anggota' => 'required|exists:anggotas,id',
            'jenis_kegiatan' => 'required|string|max:255',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => [
                'required',
                'date',
                'after:tanggal_peminjaman'
            ],
            'waktu_peminjaman' => 'required|date_format:H:i',
            'id_barang' => 'required|array|min:1',
            'id_barang.*' => 'required|exists:barangs,id',
            'jumlah_pinjam' => 'required|array|min:1',
            'jumlah_pinjam.*' => 'integer|min:1',
            'id_ruangan' => 'required|exists:ruangans,id',
        ], [
            'tanggal_pengembalian.after' => 'Tanggal pengembalian harus lebih besar dari tanggal peminjaman',
            'id_barang.required' => 'Minimal pilih 1 barang untuk dipinjam',
            'jumlah_pinjam.*.min' => 'Jumlah pinjam minimal 1',
        ]);


        $pm_barang = pm_barang::where('code_peminjaman', $id)->firstOrFail();


        foreach ($pm_barang->peminjaman_details as $detail) {
            $barang = Barang::find($detail->id_barang);
            if ($barang) {
                $barang->jumlah += $detail->jumlah_pinjam;
                $barang->save();
            }
        }


        $barangErrors = [];
        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);


            if ($barang->jumlah < $request->jumlah_pinjam[$index]) {
                $barangErrors[] = 'Barang "' . $barang->nama_barang . '" stok hanya tersedia ' . $barang->jumlah . ' unit, diminta ' . $request->jumlah_pinjam[$index] . ' unit';
            }
        }


        if (!empty($barangErrors)) {

            foreach ($pm_barang->peminjaman_details as $detail) {
                $barang = Barang::find($detail->id_barang);
                if ($barang) {
                    $barang->jumlah -= $detail->jumlah_pinjam;
                    $barang->save();
                }
            }

            $errorMessage = "Stok tidak mencukupi:\n" . implode("\n", $barangErrors);
            Alert::error('Stok Tidak Cukup', $errorMessage);
            return redirect()->back()->withInput();
        }


        peminjaman_detail::where('id_pm_barang', $pm_barang->id)->delete();


        $pm_barang->update([
            'id_anggota' => $request->id_anggota,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'waktu_peminjaman' => $request->waktu_peminjaman,
            'id_ruangan' => $request->id_ruangan,
        ]);


        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);


            $barang->jumlah -= $request->jumlah_pinjam[$index];
            $barang->save();


            peminjaman_detail::create([
                'id_pm_barang' => $pm_barang->id,
                'id_barang' => $id_barang,
                'jumlah_pinjam' => $request->jumlah_pinjam[$index],
            ]);
        }

        Alert::success('Success', 'Data peminjaman berhasil diperbarui')->autoClose(3000);
        return redirect()->route('pm_barang.index');
    }


    public function destroy($id)
    {
        $pm_barang = pm_barang::findOrFail($id);


        foreach ($pm_barang->peminjaman_details as $detail) {
            $barang = Barang::findOrFail($detail->id_barang);
            $barang->jumlah += $detail->jumlah_pinjam;
            $barang->save();
        }


        peminjaman_detail::where('id_pm_barang', $pm_barang->id)->delete();


        $pm_barang->delete();

        Alert::success('Success', 'Data peminjaman berhasil dihapus');
        return redirect()->route('pm_barang.index');
    }


    public function cariAnggota(Request $request)
    {
        $request->validate([
            'nim' => 'required|string'
        ]);

        $nim = $request->nim;
        $anggota = Anggota::where('nim', $nim)->first();

        if ($anggota) {
            return response()->json([
                'success' => true,
                'anggota' => [
                    'id' => $anggota->id,
                    'nama' => $anggota->nama,
                    'nim' => $anggota->nim,
                    'email' => $anggota->email ?? null,
                    'telepon' => $anggota->telepon ?? null,
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'NIM tidak ditemukan dalam database'
            ]);
        }
    }


    public function validateDates(Request $request)
    {
        try {
            $tanggal_peminjaman = Carbon::parse($request->tanggal_peminjaman);
            $tanggal_pengembalian = Carbon::parse($request->tanggal_pengembalian);
            $today = Carbon::today();

            $errors = [];

            // Validasi tanggal peminjaman tidak boleh kurang dari hari ini
            if ($tanggal_peminjaman->lessThan($today)) {
                $errors[] = 'Tanggal peminjaman tidak boleh kurang dari hari ini (' . $today->format('d-m-Y') . ')';
            }

            // Validasi tanggal pengembalian harus lebih besar dari tanggal peminjaman
            if ($tanggal_pengembalian->lessThanOrEqualTo($tanggal_peminjaman)) {
                $errors[] = 'Tanggal pengembalian harus lebih besar dari tanggal peminjaman';
            }

            // Hitung durasi peminjaman
            $durasi = $tanggal_peminjaman->diffInDays($tanggal_pengembalian);

            return response()->json([
                'valid' => empty($errors),
                'errors' => $errors,
                'durasi' => $durasi,
                'message' => empty($errors) ? "Durasi peminjaman: {$durasi} hari" : implode('. ', $errors)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'errors' => ['Format tanggal tidak valid'],
                'message' => 'Format tanggal tidak valid'
            ]);
        }
    }

    // Method untuk mendapatkan stok barang (AJAX)
    public function getStokBarang($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            return response()->json([
                'success' => true,
                'stok' => $barang->jumlah,
                'nama_barang' => $barang->nama_barang,
                'code_barang' => $barang->code_barang
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ]);
        }
    }
}
