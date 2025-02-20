<?php

namespace App\Http\Controllers;

use App\Models\pm_barang;
use App\Models\p_barang;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class PBarangController extends Controller
{
    public function __construct()
    {
        $this -> middleware('auth');
    }
    public function index()
    {
        $p_barang =  p_barang::all();
        confirmDelete('Delete','Are you sure?');
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
            'nama_pengembali' => 'required',
            'tanggal_pengembalian' => 'required',
            'keterangan' => 'required',

        ]);

        $p_barang = new p_barang();
        $p_barang->nama_pengembali = $request->nama_pengembali;
        $p_barang->id_pm_barang = $request->id_pm_barang;
        $p_barang->tanggal_pengembalian = $request->tanggal_pengembalian;
        $p_barang->keterangan = $request->keterangan;

        Alert::success('Success','data berhasil disimpan')->autoClose(1000);
        $p_barang->save();

        return redirect()->route('p_barang.index');
    }


    public function show(p_barang $barang)
    {
        //
    }


    public function edit($id)
    {
        $pm_barang = pm_barang::all();
        $p_barang = p_barang::findOrFail($id);
        return view('p_barang.edit', compact('p_barang','pm_barang'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_pengembali' => 'required',
            'tanggal_pengembalian' => 'required',
            'keterangan' => 'required',

        ]);

        $p_barang = p_barang::findOrFail($id);
        $p_barang->nama_pengembali = $request->nama_pengembali;
        $p_barang->id_pm_barang = $request->id_pm_barang;
        $p_barang->tanggal_pengembalian = $request->tanggal_pengembalian;
        $p_barang->keterangan = $request->keterangan;

        Alert::success('Success','data berhasil diubah')->autoClose(1000);
        $p_barang->save();
        return redirect()->route('p_barang.index');
    }

    public function destroy($id)
    {
        $p_barang = p_barang::findOrFail($id);
        $p_barang->delete();
        Alert::success('success','Data berhasil Dihapus');
        return redirect()->route('p_barang.index');
    }
}
