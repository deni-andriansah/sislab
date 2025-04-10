<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\pm_ruangan;
use App\Models\anggota;
use App\Models\PeminjamanDetailRuangan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use PDF;

class PmRuanganController extends Controller
{
    public function viewPDF(Request $request)
    {
        $pm_ruangan = pm_ruangan::findOrFail($request->idPeminjaman);

        $data = [
            'title' => 'Data Produk',
            'date' => date('m/d/Y'),
            'pm_ruangan' => $pm_ruangan,
        ];

        $pdf = PDF::loadView('pm_ruangan.export-pdf', $data)
            ->setPaper('a4', 'portrait');
            return response($pdf->stream(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="document.pdf"');
   }

    public function viewRUANGAN(Request $request)
    {
        $pm_ruangan = pm_ruangan::findOrFail($request->idPeminjaman);

        $isi = [
            'date' => date('m/d/Y'),
            'pm_ruangan' => $pm_ruangan,

        ];

        $pdf = PDF::loadView('pm_ruangan.export-ruangan', $isi)
            ->setPaper('a4', 'portrait');
            return response($pdf->stream(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="document.pdf"');
  }

    public function __construct()
    {
        $this -> middleware('auth');
    }
    public function index()
    {
        $pm_ruangan =  pm_ruangan::all();

        confirmDelete('Delete','Are you sure?');
        return view('pm_ruangan.index', compact('pm_ruangan'));
    }


    public function create()
    {
        $anggota =  anggota::all();
        $ruangan =  Ruangan::all();
        return view('pm_ruangan.create', compact('anggota','ruangan'));
    }


    public function store(Request $request)
{

    $pm_ruangan = new pm_ruangan();
    $pm_ruangan->code_peminjaman = $request->code_peminjaman;
    $pm_ruangan->id_anggota = $request->id_anggota;
    $pm_ruangan->jenis_kegiatan = $request->jenis_kegiatan;
    $pm_ruangan->tanggal_peminjaman = $request->tanggal_peminjaman;
    $pm_ruangan->waktu_peminjaman = $request->waktu_peminjaman;

    $pm_ruangan->save();

    // Simpan ke tabel detail ruangan
    foreach ($request->id_ruangan as $id_ruangan) {
        $detail = new PeminjamanDetailRuangan();
        $detail->id_pm_ruangan = $pm_ruangan->id;
        $detail->id_ruangan = $id_ruangan;
        $detail->save();
    }

    Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
    return redirect()->route('pm_ruangan.index');
}


    public function show(pm_ruangan $barang)
    {
        //
    }


    public function edit($id)
    {
        $anggota = anggota::all();
        $ruangan = Ruangan::all();
        $pm_ruangan = pm_ruangan::findOrFail($id);
        $details = PeminjamanDetailRuangan::where('id_pm_ruangan', $id)->get();

        return view('pm_ruangan.edit', compact('pm_ruangan', 'anggota', 'ruangan', 'details'));
    }



    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code_peminjaman' => 'required',
            'tanggal_peminjaman' => 'required',
            'jenis_kegiatan' => 'required',
            'waktu_peminjaman' => 'required',
            'id_ruangan' => 'required|array|min:1',
            ]);

        $pm_ruangan = pm_ruangan::findOrFail($id);
        $pm_ruangan->code_peminjaman = $request->code_peminjaman;
        $pm_ruangan->id_anggota = $request->id_anggota;
        $pm_ruangan->jenis_kegiatan = $request->jenis_kegiatan;
        $pm_ruangan->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_ruangan->waktu_peminjaman = $request->waktu_peminjaman;

        $pm_ruangan->save();

        // Hapus detail lama
        PeminjamanDetailRuangan::where('id_pm_ruangan', $id)->delete();

        // Simpan detail baru
        foreach ($request->id_ruangan as $id_ruangan) {
            $detail = new PeminjamanDetailRuangan();
            $detail->id_pm_ruangan = $pm_ruangan->id;
            $detail->id_ruangan = $id_ruangan;
            $detail->save();
        }

        Alert::success('Success','Data berhasil diubah')->autoClose(1000);
        return redirect()->route('pm_ruangan.index');
    }



    public function destroy($id)
    {
        $pm_ruangan = pm_ruangan::findOrFail($id);
        $pm_ruangan->delete();
        Alert::success('success','Data berhasil Dihapus');
        return redirect()->route('pm_ruangan.index');
    }
}
