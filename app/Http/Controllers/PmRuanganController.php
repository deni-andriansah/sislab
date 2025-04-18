<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\pm_Ruangan;
use App\Models\anggota;
use App\Models\PeminjamanDetailRuangan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class PmRuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Mengambil data peminjaman ruangan beserta detailnya
        $pm_ruangan = pm_Ruangan::with('PeminjamanDetailRuangan.ruangan')->get();
        confirmDelete('Delete', 'Are you sure?');
        return view('pm_ruangan.index', compact('pm_ruangan'));
    }

    public function create()
    {
        $anggota = anggota::all(); // Mengambil semua data anggota
        $ruangan = Ruangan::all(); // Mengambil semua data ruangan
        return view('pm_ruangan.create', compact('anggota', 'ruangan'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'code_peminjaman' => 'required',
            'id_anggota' => 'required|exists:anggotas,id',
            'jenis_kegiatan' => 'required',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'waktu_peminjaman' => 'required',
            'id_ruangan' => 'required|array|min:1',
        ]);

        // Menyimpan data peminjaman ruangan
        $pm_ruangan = new pm_Ruangan();
        $pm_ruangan->code_peminjaman = $request->code_peminjaman;
        $pm_ruangan->id_anggota = $request->id_anggota;
        $pm_ruangan->jenis_kegiatan = $request->jenis_kegiatan;
        $pm_ruangan->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_ruangan->tanggal_pengembalian = $request->tanggal_pengembalian;
        $pm_ruangan->waktu_peminjaman = $request->waktu_peminjaman;
        $pm_ruangan->save();

        // Menyimpan detail ruangan yang dipilih
        foreach ($request->id_ruangan as $id_ruangan) {
            PeminjamanDetailRuangan::create([
                'id_pm_ruangan' => $pm_ruangan->id,
                'id_ruangan' => $id_ruangan,
            ]);
        }

        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        return redirect()->route('pm_ruangan.index');
    }

    public function edit($id)
    {
        $anggota = Anggota::all();
        $ruangan = Ruangan::all();
        $pm_ruangan = pm_Ruangan::findOrFail($id);
        $selectedRuangan = PeminjamanDetailRuangan::where('id_pm_ruangan', $id)->pluck('id_ruangan')->toArray();

        return view('pm_ruangan.edit', compact('pm_ruangan', 'anggota', 'ruangan', 'selectedRuangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code_peminjaman' => 'required',
            'id_anggota' => 'required|exists:anggotas,id',
            'jenis_kegiatan' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'waktu_peminjaman' => 'required',
            'id_ruangan' => 'required|array|min:1',
        ]);

        $pm_ruangan = pm_Ruangan::findOrFail($id);
        $pm_ruangan->code_peminjaman = $request->code_peminjaman;
        $pm_ruangan->id_anggota = $request->id_anggota;
        $pm_ruangan->jenis_kegiatan = $request->jenis_kegiatan;
        $pm_ruangan->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_ruangan->tanggal_pengembalian = $request->tanggal_pengembalian;
        $pm_ruangan->waktu_peminjaman = $request->waktu_peminjaman;
        $pm_ruangan->save();

        // Hapus detail ruangan lama dan tambahkan detail baru
        PeminjamanDetailRuangan::where('id_pm_ruangan', $id)->delete();

        foreach ($request->id_ruangan as $id_ruangan) {
            PeminjamanDetailRuangan::create([
                'id_pm_ruangan' => $pm_ruangan->id,
                'id_ruangan' => $id_ruangan,
            ]);
        }

        Alert::success('Success', 'Data berhasil diperbarui')->autoClose(1000);
        return redirect()->route('pm_ruangan.index');
    }

    public function destroy($id)
    {
        $pm_ruangan = pm_Ruangan::findOrFail($id);
        $pm_ruangan->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('pm_ruangan.index');
    }

    public function viewPDF(Request $request)
    {
        $pm_ruangan = pm_Ruangan::findOrFail($request->idPeminjaman);
        $data = [
            'title' => 'Data Produk',
            'date' => date('m/d/Y'),
            'pm_ruangan' => $pm_ruangan,
        ];

        $pdf = PDF::loadView('pm_ruangan.export-pdf', $data)->setPaper('a4', 'portrait');
        return response($pdf->stream(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="document.pdf"');
    }

    public function viewRUANGAN(Request $request)
    {
        $pm_ruangan = pm_Ruangan::findOrFail($request->idPeminjaman);
        $isi = [
            'date' => date('m/d/Y'),
            'pm_ruangan' => $pm_ruangan,
        ];

        $pdf = PDF::loadView('pm_ruangan.export-ruangan', $isi)->setPaper('a4', 'portrait');
        return response($pdf->stream(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="document.pdf"');
    }
}
