<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return response()->json([
            'success' => true,
            'message' => 'List kategori',
            'data' => $kategori
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
        ]);

        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $kategori
        ], 201);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $kategori
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required',
        ]);

        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate',
            'data' => $kategori
        ], 200);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ], 200);
    }
}
