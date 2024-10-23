<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Merk;
use App\Models\Kategori;
use App\Models\Kondisi;
use RealRashid\SweetAlert\Facades\Alert;

use Storage;
use Illuminate\Http\Request;

class BarangController extends Controller
{

    public function index()
    {
        $barang =  Barang::all();
        confirmDelete('Delete','Are you sure?');
        return view('barang.index', compact('barang'));
    }


    public function create()
    {
        $merk =  Merk::all();
        $kategori = Kategori::all();
        $kondisi = Kondisi::all();
        return view('barang.create', compact('merk', 'kategori', 'kondisi'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'posisi' => 'required',
            'spek' => 'required',

        ]);

        $barang = new barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->id_merk = $request->id_merk;
        $barang->id_kategori = $request->id_kategori;
        $barang->id_kondisi = $request->id_kondisi;
        $barang->posisi = $request->posisi;
        $barang->spek = $request->spek;

        Alert::success('Success','data berhasil disimpan')->autoClose(1000);
        $barang->save();

        return redirect()->route('barang.index');
    }


    public function show(barang $barang)
    {
        //
    }


    public function edit($id)
    {
        $merk =  Merk::all();
        $kategori = Kategori::all();
        $kondisi = Kondisi::all();
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang', 'merk', 'kategori', 'kondisi'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'posisi' => 'required',
            'spek' => 'required',

        ]);

        $barang = Barang::findOrFail($id);
        $barang->nama_barang = $request->nama_barang;
        $barang->id_merk = $request->id_merk;
        $barang->id_kategori = $request->id_kategori;
        $barang->id_kondisi = $request->id_kondisi;
        $barang->posisi = $request->posisi;
        $barang->spek = $request->spek;

        Alert::success('Success','data berhasil dirubah')->autoClose(1000);
        $barang->save();

        return redirect()->route('barang.index');
    }


    public function destroy($id)
    {
        $barang = barang::findOrFail($id);
        $barang->delete();
        Alert::success('success','Data berhasil Dihapus');
        return redirect()->route('barang.index');
    }
}
