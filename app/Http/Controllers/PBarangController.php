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
        $validated = $request->validate([
            'id_pm_barang' => 'required|exists:pm__barangs,id',
            'tanggal_selesai' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $pm_barang = pm_barang::findOrFail($request->id_pm_barang);

        $tanggal_kembali = Carbon::parse($pm_barang->tanggal_pengembalian);
        $tanggal_selesai = Carbon::parse($request->tanggal_selesai);

        $denda = 0;

        if ($request->keterangan && strpos(strtolower($request->keterangan), 'rusak') !== false) {
            $denda += 5000;
        }

        if ($tanggal_selesai->greaterThan($tanggal_kembali)) {
            $daysLate = $tanggal_kembali->diffInDays($tanggal_selesai);
            $denda += $daysLate * 10000;
        }

        $p_barang = p_barang::create([
            'id_pm_barang' => $request->id_pm_barang,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
        ]);

        $peminjaman_details = peminjaman_detail::where('id_pm_barang', $pm_barang->id)->get();

        foreach ($peminjaman_details as $detail) {
            $barang = Barang::findOrFail($detail->id_barang);
            $barang->jumlah += $detail->jumlah_pinjam;
            $barang->save();
        }

        $pm_barang->save();

        return redirect()->route('p_barang.index')->with('success', "Pengembalian berhasil dengan denda Rp. " . number_format($denda, 0, ',', '.'));
    }

    public function show($id)
    {
        $pengembalian = p_barang::findOrFail($id);
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function destroy($id)
    {
        $p_barang = p_barang::find($id);

        if (!$p_barang) {
            return redirect()->route('p_barang.index')->with('error', 'Data pengembalian tidak ditemukan.');
        }

        $details = peminjaman_detail::where('id_pm_barang', $p_barang->id_pm_barang)->get();

        foreach ($details as $detail) {
            $barang = Barang::find($detail->id_barang);
            if ($barang) {
                $barang->jumlah -= $detail->jumlah_pinjam;
                $barang->save();
            }
        }

        $p_barang->delete();

        Alert::success('Success', 'Data pengembalian berhasil dihapus.');
        return redirect()->route('p_barang.index');
    }

    public function getDetailPeminjaman($id)
    {
        $pm = pm_barang::with(['anggota', 'detail.barang'])->find($id);
        if (!$pm) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

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
