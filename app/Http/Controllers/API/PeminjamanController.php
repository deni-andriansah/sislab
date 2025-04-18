<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Ruangan;
use App\Models\pm_barang;
use App\Models\peminjaman_detail;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = pm_barang::with('anggota', 'ruangan', 'peminjaman_details.barang')->get();

        return response()->json([
            'success' => true,
            'data' => $peminjaman
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_kegiatan' => 'required',
            'id_barang' => 'required|array',
            'jumlah_pinjam' => 'required|array',
            'jumlah_pinjam.*' => 'integer|min:1',
            'tanggal_peminjaman' => 'required|date',
            'waktu_peminjaman' => 'required',
            'nim' => 'required',
        ]);

        $anggota = Anggota::where('nim', $request->nim)->first();
        if (!$anggota) {
            return response()->json(['success' => false, 'message' => 'NIM tidak ditemukan'], 404);
        }

        $codePeminjaman = 'PM-' . date('Ymd') . '-' . mt_rand(1000, 9999);

        $pm_barang = new pm_barang();
        $pm_barang->code_peminjaman = $codePeminjaman;
        $pm_barang->id_anggota = $anggota->id;
        $pm_barang->jenis_kegiatan = $request->jenis_kegiatan;
        $pm_barang->id_ruangan = $request->id_ruangan;
        $pm_barang->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_barang->waktu_peminjaman = $request->waktu_peminjaman;
        $pm_barang->save();

        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);

            if ($barang->jumlah < $request->jumlah_pinjam[$index]) {
                return response()->json(['success' => false, 'message' => 'Stok barang tidak mencukupi'], 400);
            }

            $barang->jumlah -= $request->jumlah_pinjam[$index];
            $barang->save();

            peminjaman_detail::create([
                'id_pm_barang' => $pm_barang->id,
                'id_barang' => $id_barang,
                'jumlah_pinjam' => $request->jumlah_pinjam[$index],
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Peminjaman berhasil disimpan']);
    }

    public function show($code)
    {
        $peminjaman = pm_barang::with('anggota', 'ruangan', 'peminjaman_details.barang')
            ->where('code_peminjaman', $code)->first();

        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $peminjaman]);
    }

    public function update(Request $request, $code)
    {
        $validated = $request->validate([
            'id_anggota' => 'required',
            'jenis_kegiatan' => 'required',
            'id_barang' => 'required|array',
            'jumlah_pinjam' => 'required|array',
            'jumlah_pinjam.*' => 'integer|min:1',
            'tanggal_peminjaman' => 'required|date',
            'waktu_peminjaman' => 'required',
            'id_ruangan' => 'required',
        ]);

        $pm_barang = pm_barang::where('code_peminjaman', $code)->firstOrFail();

        foreach ($pm_barang->peminjaman_details as $detail) {
            $barangLama = Barang::findOrFail($detail->id_barang);
            $barangLama->jumlah += $detail->jumlah_pinjam;
            $barangLama->save();
        }

        peminjaman_detail::where('id_pm_barang', $pm_barang->id)->delete();

        $pm_barang->update([
            'id_anggota' => $request->id_anggota,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'id_ruangan' => $request->id_ruangan,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'waktu_peminjaman' => $request->waktu_peminjaman,
        ]);

        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);

            if ($barang->jumlah < $request->jumlah_pinjam[$index]) {
                return response()->json(['success' => false, 'message' => 'Stok barang tidak mencukupi'], 400);
            }

            $barang->jumlah -= $request->jumlah_pinjam[$index];
            $barang->save();

            peminjaman_detail::create([
                'id_pm_barang' => $pm_barang->id,
                'id_barang' => $id_barang,
                'jumlah_pinjam' => $request->jumlah_pinjam[$index],
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Data peminjaman berhasil diperbarui']);
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

        return response()->json(['success' => true, 'message' => 'Data peminjaman berhasil dihapus']);
    }

    public function cariAnggota(Request $request)
    {
        $nim = $request->nim;
        $anggota = Anggota::where('nim', $nim)->first();

        if ($anggota) {
            return response()->json([
                'success' => true,
                'data' => [
                    'nama_peminjam' => $anggota->nama_peminjam,
                    'nim' => $anggota->nim
                ]
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'NIM tidak ditemukan'], 404);
        }
    }
}
