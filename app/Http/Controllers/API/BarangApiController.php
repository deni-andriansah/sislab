<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangApiController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil diambil',
            'dataBarang' => $barang
        ], 200);
    }

    public function show($id)
    {
        $barang = Barang::with('kategori')->find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data barang tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail barang berhasil diambil',
            'dataBarang' => $barang
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_barang' => 'required|unique:barangs,code_barang',
            'nama_barang' => 'required',
            'merk' => 'required',
            'detail' => 'required',
            'jumlah' => 'required|integer',
            'id_kategori' => 'required|exists:kategoris,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $barang = Barang::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan',
            'dataBarang' => $barang
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'code_barang' => 'required|unique:barangs,code_barang,' . $id,
            'nama_barang' => 'required',
            'merk' => 'required',
            'detail' => 'required',
            'jumlah' => 'required|integer',
            'id_kategori' => 'required|exists:kategoris,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $barang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diperbarui',
            'dataBarang' => $barang
        ], 200);
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan',
            ], 404);
        }

        $isDipinjam = $barang->peminjaman_details()
            ->whereHas('pm_barang', function ($query) {
                $query->whereNotIn('code_peminjaman', function ($subQuery) {
                    $subQuery->select('code_peminjaman')->from('p_barangs');
                });
            })->exists();

        if ($isDipinjam) {
            return response()->json([
                'success' => false,
                'message' => 'Barang masih dipinjam dan tidak bisa dihapus.',
            ], 400);
        }

        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dihapus',
        ], 200);
    }
}
