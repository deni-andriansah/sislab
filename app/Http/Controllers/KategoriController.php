<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kategori = Kategori::all();
        confirmDelete('Hapus Kategori?', 'Data yang sudah dihapus tidak bisa dikembalikan!');
        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required',
        ]);

        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        return redirect()->route('kategori.index');
    }

    public function show(Kategori $kategori)
    {
        //
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_kategori' => 'required',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        Alert::success('Success', 'Data berhasil diubah')->autoClose(1000);
        return redirect()->route('kategori.index');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Validasi: cek apakah masih digunakan di tabel barang
        if ($kategori->barang()->count() > 0) {
            Alert::error('Gagal Dihapus', 'Kategori masih digunakan oleh data barang')->autoClose(3000);
            return redirect()->route('kategori.index');
        }

        $kategori->delete();

        Alert::success('Success', 'Data berhasil dihapus')->autoClose(1000);
        return redirect()->route('kategori.index');
    }
}
