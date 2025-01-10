<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\anggota;
use App\Models\Ruangan;
use App\Models\pm_barang;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Illuminate\Http\Request;

class PmBarangController extends Controller
{
    public function viewPDF(Request $request)
    {
        $pm_barang = pm_barang::findOrFail($request->idPeminjaman);

        $data = [
            'date' => date('m/d/Y'),
            'pm_barang' => $pm_barang,
        ];

        $pdf = PDF::loadView('pm_barang.export-pdf', $data)->setPaper('a4', 'portrait');

        return response($pdf->stream(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="document.pdf"');
    }

    public function viewBARANG(Request $request)
    {
        $pm_barang = pm_barang::findOrFail($request->idPeminjaman);

        $isi = [
            'date' => date('m/d/Y'),
            'pm_barang' => $pm_barang,

        ];

        $pdf = PDF::loadView('pm_barang.export-barang', $isi)
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
        $pm_barang =  pm_barang::all();
        confirmDelete('Delete','Are you sure?');
        return view('pm_barang.index', compact('pm_barang'));
    }


    public function create()
    {
        $barang =  Barang::all();
        $ruangan =  Ruangan::all();
        $anggota = anggota::all();
        return view('pm_barang.create', compact('barang','ruangan', 'anggota'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_peminjaman' => 'required',
            'jenis_kegitan' => 'required',
            'tanggal_peminjaman' => 'required',
            'waktu_pengerjaan' => 'required',
            'cover' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf|max:1024',

        ]);

        $pm_barang = new pm_barang();
        $pm_barang->code_peminjaman = $request->code_peminjaman;
        $pm_barang->id_anggota = $request->id_anggota;
        $pm_barang->jenis_kegitan = $request->jenis_kegitan;
        $pm_barang->id_barang = $request->id_barang;
        $pm_barang->id_ruangan = $request->id_ruangan;
        $pm_barang->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_barang->waktu_pengerjaan = $request->waktu_pengerjaan;


        if ($request->hasFile('cover')) {
            $img = $request->file('cover');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/pm_barang', $name);
            $pm_barang->cover = $name;
        }

        Alert::success('Success','data berhasil disimpan')->autoClose(1000);
        $pm_barang->save();

        return redirect()->route('pm_barang.index');
    }


    public function show(pm_barang $barang)
    {
        //
    }


    public function edit($id)
    {
        $barang =  Barang::all();
        $ruangan =  Ruangan::all();
        $anggota = anggota::all();
        $pm_barang = pm_barang::findOrFail($id);
        return view('pm_barang.edit', compact('pm_barang','barang','ruangan','anggota'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code_peminjaman' => 'required',
            'jenis_kegitan' => 'required',
            'tanggal_peminjaman' => 'required',
            'waktu_pengerjaan' => 'required',
            'cover' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf|max:1024',
        ]);

        $pm_barang = pm_barang::findOrFail($id);
        $pm_barang->code_peminjaman = $request->code_peminjaman;
        $pm_barang->id_anggota = $request->id_anggota;
        $pm_barang->jenis_kegitan = $request->jenis_kegitan;
        $pm_barang->id_barang = $request->id_barang;
        $pm_barang->id_ruangan = $request->id_ruangan;
        $pm_barang->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_barang->waktu_pengerjaan = $request->waktu_pengerjaan;

        if ($request->hasFile('cover')) {
            $img = $request->file('cover');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/pm_barang', $name);
            $pm_barang->cover = $name;
        }

        Alert::success('Success','data berhasil diubah')->autoClose(1000);
        $pm_barang->save();
        return redirect()->route('pm_barang.index');
    }

    public function destroy($id)
    {
        $pm_barang = pm_barang::findOrFail($id);
        $pm_barang->delete();
        Alert::success('success','Data berhasil Dihapus');
        return redirect()->route('pm_barang.index');
    }
}
