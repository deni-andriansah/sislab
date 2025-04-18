<?php

namespace App\Http\Controllers;

use App\Models\p_ruangan;
use App\Models\pm_ruangan;
use App\Models\peminjamandetailruangan;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PRuanganController extends Controller
{
    public function index()
{
    // Menampilkan list pengembalian ruangan yang telah dilakukan
    $p_ruangan = p_ruangan::with('pm_ruangan')->get(); // Hapus tanda kurung siku
    return view('p_ruangan.index', compact('p_ruangan'));
}

public function edit($id)
{
    $p_ruangan = p_ruangan::findOrFail($id);
    $pm_ruangan = pm_ruangan::all();

    $tanggal_kembali = Carbon::parse($p_ruangan->pm_ruangan->tanggal_pengembalian);
    $tanggal_selesai = Carbon::parse($p_ruangan->tanggal_selesai);
    $denda = 0;

    if ($tanggal_selesai->greaterThan($tanggal_kembali)) {
        $daysLate = $tanggal_kembali->diffInDays($tanggal_selesai);
        $denda = $daysLate * 10000;
    }

    return view('p_ruangan.edit', compact('p_ruangan', 'pm_ruangan', 'denda'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'tanggal_selesai' => 'required|date',
        'keterangan' => 'nullable|string',
    ]);

    $p_ruangan = p_ruangan::findOrFail($id);
    $pm_ruangan = pm_ruangan::findOrFail($p_ruangan->id_pm_ruangan);

    $tanggal_kembali = Carbon::parse($pm_ruangan->tanggal_pengembalian);
    $tanggal_selesai = Carbon::parse($request->tanggal_selesai);

    $denda = 0;

    if ($request->keterangan && strpos(strtolower($request->keterangan), 'rusak') !== false) {
        $denda += 5000;
    }

    if ($tanggal_selesai->greaterThan($tanggal_kembali)) {
        $daysLate = $tanggal_kembali->diffInDays($tanggal_selesai);
        $denda += $daysLate * 10000;
    }

    $p_ruangan->update([
        'tanggal_selesai' => $request->tanggal_selesai,
        'keterangan' => $request->keterangan,
    ]);

    $detailRuangan = peminjamandetailruangan::where('id_pm_ruangan', $p_ruangan->id_pm_ruangan)->get();
    foreach ($detailRuangan as $detail) {
        $ruangan = Ruangan::find($detail->id_ruangan);
        if ($ruangan) {
            $ruangan->status = 'Tersedia';
            $ruangan->save();
        }
    }

    return redirect()->route('p_ruangan.index')->with('success', "Pengembalian berhasil diupdate. Denda: Rp. " . number_format($denda, 0, ',', '.'));
}

    public function show($id)
    {
        $pengembalian = p_ruangan::findOrFail($id);
        return view('pengembalian.show', compact('pengembalian'));
    }
}
