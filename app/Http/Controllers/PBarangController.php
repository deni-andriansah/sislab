<?php

namespace App\Http\Controllers;

use App\Models\p_barang;
use App\Models\pm_barang;
use App\Models\peminjaman_detail;
use App\Models\Barang;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PBarangController extends Controller
{
    public function index()
    {
        $p_barang = p_barang::with('pm_barang')->get();
        return view('p_barang.index', compact('p_barang'));
    }

    public function create()
    {
        $pm_barang = pm_barang::all();
        return view('p_barang.create', compact('pm_barang'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'tanggal_selesai' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Mencari data pm_barang berdasarkan id_pm_barang
        $pm_barang = pm_barang::findOrFail($request->id_pm_barang);

        // Menghitung tanggal pengembalian dan keterlambatan
        $tanggal_kembali = Carbon::parse($pm_barang->tanggal_pengembalian);
        $tanggal_selesai = Carbon::parse($request->tanggal_selesai);

        $denda = 0;

        // Cek jika ada keterangan rusak dan menambahkan denda
        if ($request->keterangan && strpos(strtolower($request->keterangan), 'rusak') !== false) {
            $denda += 5000; // Denda karena kerusakan
        }

        // Cek jika terlambat mengembalikan barang
        if ($tanggal_selesai->greaterThan($tanggal_kembali)) {
            $daysLate = $tanggal_kembali->diffInDays($tanggal_selesai);
            $denda += $daysLate * 10000; // Denda keterlambatan, misalnya 10.000 per hari
        }

        // Menyimpan data pengembalian barang
        $p_barang = p_barang::create([
            'id_pm_barang' => $request->id_pm_barang,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
        ]);

        // Mengupdate jumlah barang berdasarkan peminjaman
        $peminjaman_details = peminjaman_detail::where('id_pm_barang', $pm_barang->id)->get();

        foreach ($peminjaman_details as $detail) {
            $barang = Barang::findOrFail($detail->id_barang);
            $barang->jumlah += $detail->jumlah_pinjam; // Menambahkan jumlah barang kembali
            $barang->save();
        }

        // Menyimpan perubahan pada pm_barang
        $pm_barang->save();

        // Mengarahkan kembali ke halaman utama dengan pesan sukses
        return redirect()->route('p_barang.index')->with('success', "Pengembalian berhasil dengan denda Rp. " . number_format($denda, 0, ',', '.'));
    }

    public function edit($id)
    {
        // Mengambil data p_barang berdasarkan id
        $p_barang = p_barang::findOrFail($id);
        $pm_barang = pm_barang::all();

        // Menghitung denda di controller dan mengirimkan ke view
        $tanggal_kembali = Carbon::parse($p_barang->pm_barang->tanggal_pengembalian);
        $tanggal_selesai = Carbon::parse($p_barang->tanggal_selesai);
        $denda = 0;

        if ($tanggal_selesai->greaterThan($tanggal_kembali)) {
            $daysLate = $tanggal_kembali->diffInDays($tanggal_selesai);
            $denda = $daysLate * 10000; // Denda keterlambatan, misalnya 10.000 per hari
        }

        return view('p_barang.edit', compact('p_barang', 'pm_barang', 'denda'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'tanggal_selesai' => 'required|date', // Validasi tanggal_selesai
            'keterangan' => 'nullable|string', // Keterangan bersifat opsional
        ]);

        // Mencari data p_barang yang akan diupdate
        $p_barang = p_barang::findOrFail($id);
        $pm_barang = pm_barang::findOrFail($request->id_pm_barang);

        // Menghitung denda jika ada keterlambatan
        $tanggal_kembali = Carbon::parse($pm_barang->tanggal_pengembalian);
        $tanggal_selesai = Carbon::parse($request->tanggal_selesai);

        $denda = 0;

        // Cek jika ada keterangan rusak dan menambahkan denda
        if ($request->keterangan && strpos(strtolower($request->keterangan), 'rusak') !== false) {
            $denda += 5000; // Denda karena kerusakan barang
        }

        // Cek jika terlambat mengembalikan barang
        if ($tanggal_selesai->greaterThan($tanggal_kembali)) {
            $daysLate = $tanggal_kembali->diffInDays($tanggal_selesai);
            $denda += $daysLate * 10000; // Denda keterlambatan, misalnya 10.000 per hari
        }

        // Kembalikan stok barang sesuai peminjaman sebelumnya
        $old_details = peminjaman_detail::where('id_pm_barang', $p_barang->id_pm_barang)->get();
        foreach ($old_details as $detail) {
            $barang = Barang::findOrFail($detail->id_barang);
            $barang->jumlah -= $detail->jumlah_pinjam; // Mengembalikan jumlah barang
            $barang->save();
        }

        // Update data pengembalian barang
        $p_barang->update([
            'id_pm_barang' => $request->id_pm_barang,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
        ]);

        // Tambahkan kembali stok barang sesuai peminjaman terbaru
        $new_details = peminjaman_detail::where('id_pm_barang', $request->id_pm_barang)->get();
        foreach ($new_details as $detail) {
            $barang = Barang::findOrFail($detail->id_barang);
            $barang->jumlah += $detail->jumlah_pinjam; // Menambahkan jumlah barang
            $barang->save();
        }

        // Mengarahkan kembali ke halaman utama dengan pesan sukses
        return redirect()->route('p_barang.index')->with('success', "Pengembalian berhasil diupdate. Denda: Rp. " . number_format($denda, 0, ',', '.'));
    }

    public function show($id)
    {
        // Menampilkan detail pengembalian barang
        $pengembalian = p_barang::findOrFail($id);
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function destroy($id)
    {
        // Mencari data p_barang untuk dihapus
        $p_barang = p_barang::find($id);

        if (!$p_barang) {
            return redirect()->route('p_barang.index')->with('error', 'Data pengembalian tidak ditemukan.');
        }

        // Mengurangi jumlah barang yang dipinjam
        $details = peminjaman_detail::where('id_pm_barang', $p_barang->id_pm_barang)->get();

        foreach ($details as $detail) {
            $barang = Barang::find($detail->id_barang);
            if ($barang) {
                $barang->jumlah -= $detail->jumlah_pinjam; // Mengurangi jumlah barang
                $barang->save();
            }
        }

        // Menghapus data pengembalian barang
        $p_barang->delete();

        // Menampilkan pesan sukses setelah penghapusan
        Alert::success('Success', 'Data pengembalian berhasil dihapus.');
        return redirect()->route('p_barang.index');
    }

    public function getDetailPeminjaman($id)
    {
        // Mengambil detail peminjaman dengan relasi anggota dan barang
        $pm = pm_barang::with(['anggota', 'detail.barang'])->find($id);
        if (!$pm) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Menampilkan data peminjaman
        return response()->json([
            'nama' => $pm->anggota->nama ?? 'Tidak diketahui',
            'barang' => $pm->detail->map(function ($item) {
                return [
                    'code_barang' => $item->barang->code_barang ?? '-',
                    'nama_barang' => $item->barang->nama_barang ?? '-',
                ];
            }),
        ]);
    }
}
