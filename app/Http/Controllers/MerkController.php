<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    public function __construct()
    {
        $this -> middleware('auth');
    }
    public function index()
    {
        $merk = Merk::all();
        confirmDelete('Delete','Are you sure?');
        return view('merk.index', compact('merk'));
    }


    public function create()
    {
        return view('merk.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_merk' => 'required',

        ]);

        $merk = new Merk();
        $merk->nama_merk = $request->nama_merk;

        Alert::success('Success','data berhasil disimpan')->autoClose(1000);
        $merk->save();

        return redirect()->route('merk.index');
    }


    public function show(Merk $merk)
    {
        //
    }


    public function edit($id)
    {
        $merk = Merk::findOrFail($id);
        return view('merk.edit', compact('merk'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_merk' => 'required',

        ]);

        $merk = Merk::findOrFail($id);
        $merk->nama_merk = $request->nama_merk;


        Alert::success('Success','data berhasil diubah')->autoClose(1000);
        $merk->save();
        return redirect()->route('merk.index');
    }


    public function destroy($id)
    {
        $merk = Merk::findOrFail($id);
        $merk->delete();
        Alert::success('success','Data berhasil Dihapus');
        return redirect()->route('merk.index');
    }
}
