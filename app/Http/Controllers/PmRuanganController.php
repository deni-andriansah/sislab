<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\pm_Ruangan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use PDF;

class PmRuanganController extends Controller
{
    public function viewPDF()
    {
        $pm_ruangan = pm_ruangan::latest()->get();

        $data = [
            'title' => 'Data Produk',
            'date' => date('m/d/Y'),
            'pm_ruangan' => $pm_ruangan,
        ];

        $pdf = PDF::loadView('pm_ruangan.export-pdf', $data)
            ->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function viewRUANGAN()
    {
        $pm_ruangan = pm_ruangan::latest()->get();

        $isi = [
            'date' => date('m/d/Y'),
            'pm_ruangan' => $pm_ruangan,

        ];

        $pdf = PDF::loadView('pm_ruangan.export-ruangan', $isi)
            ->setPaper('a4', 'portrait');
        return $pdf->stream();
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
        $ruangan =  Ruangan::all();
        return view('pm_ruangan.create', compact('ruangan'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'penanggungjawab' => 'required',
            'instansi' => 'required',
            'jenis_kegiatan' => 'required',
            'tanggal_peminjaman' => 'required',
            'tanggal_pengembalian' => 'required',
            'keterangan' => 'required',
            'cover' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf|max:1024',
        ]);

        $pm_ruangan = new pm_ruangan();
        $pm_ruangan->penanggungjawab = $request->penanggungjawab;
        $pm_ruangan->instansi = $request->instansi;
        $pm_ruangan->jenis_kegiatan = $request->jenis_kegiatan;
        $pm_ruangan->id_ruangan = $request->id_ruangan;
        $pm_ruangan->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_ruangan->tanggal_pengembalian = $request->tanggal_pengembalian;
        $pm_ruangan->keterangan = $request->keterangan;

        if ($request->hasFile('cover')) {
            $img = $request->file('cover');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/pm_ruangan', $name);
            $pm_ruangan->cover = $name;
        }

        Alert::success('Success','data berhasil disimpan')->autoClose(1000);
        $pm_ruangan->save();

        return redirect()->route('pm_ruangan.index');
    }


    public function show(pm_ruangan $barang)
    {
        //
    }


    public function edit($id)
    {
        $ruangan =  Ruangan::all();
        $pm_ruangan = pm_ruangan::findOrFail($id);
        return view('pm_ruangan.edit', compact('pm_ruangan','ruangan'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'penanggungjawab' => 'required',
            'instansi' => 'required',
            'jenis_kegiatan' => 'required',
            'tanggal_peminjaman' => 'required',
            'tanggal_pengembalian' => 'required',
            'keterangan' => 'required',
            'cover' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf|max:1024',
        ]);

        $pm_ruangan = pm_ruangan::findOrFail($id);
        $pm_ruangan->penanggungjawab = $request->penanggungjawab;
        $pm_ruangan->instansi = $request->instansi;
        $pm_ruangan->jenis_kegiatan = $request->jenis_kegiatan;
        $pm_ruangan->id_ruangan = $request->id_ruangan;
        $pm_ruangan->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_ruangan->tanggal_pengembalian = $request->tanggal_pengembalian;
        $pm_ruangan->keterangan = $request->keterangan;

        if ($request->hasFile('cover')) {
            $img = $request->file('cover');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/pm_ruangan', $name);
            $pm_ruangan->cover = $name;
        }

        Alert::success('Success','data berhasil diubah')->autoClose(1000);
        $pm_ruangan->save();
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
