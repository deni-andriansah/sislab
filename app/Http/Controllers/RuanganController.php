<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ruangan = Ruangan::all();

        // SweetAlert konfirmasi hapus
        if (session('success_message')) {
            Alert::success('Success', session('success_message'))->autoClose(2000);
        }

        confirmDelete('Hapus Ruangan', 'Apakah kamu yakin ingin menghapus ruangan ini?');

        return view('ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|unique:ruangans,nama_ruangan',
            'nama_pic' => 'required',
            'posisi_ruangan' => 'required',
        ], [
            'nama_ruangan.required' => 'Nama ruangan harus diisi!',
            'nama_ruangan.unique' => 'Nama ruangan sudah digunakan!',
            'nama_pic.required' => 'Nama PIC harus diisi!',
            'posisi_ruangan.required' => 'Posisi ruangan harus diisi!',
        ]);

        $ruangan = new Ruangan;
        $ruangan->nama_ruangan = $request->nama_ruangan;
        $ruangan->nama_pic = $request->nama_pic;
        $ruangan->posisi_ruangan = $request->posisi_ruangan;
        $ruangan->status = 'Tersedia'; // default status
        $ruangan->save();

        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        return redirect()->route('ruangan.index');
    }

    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        $request->validate([
            'nama_ruangan' => 'required|unique:ruangans,nama_ruangan,' . $ruangan->id,
            'nama_pic' => 'required',
            'posisi_ruangan' => 'required',
        ], [
            'nama_ruangan.required' => 'Nama ruangan harus diisi!',
            'nama_ruangan.unique' => 'Nama ruangan sudah digunakan!',
            'nama_pic.required' => 'Nama PIC harus diisi!',
            'posisi_ruangan.required' => 'Posisi ruangan harus diisi!',
        ]);

        $ruangan->nama_ruangan = $request->nama_ruangan;
        $ruangan->nama_pic = $request->nama_pic;
        $ruangan->posisi_ruangan = $request->posisi_ruangan;
        $ruangan->save();

        Alert::success('Success', 'Data berhasil diubah')->autoClose(1000);
        return redirect()->route('ruangan.index');
    }

    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);

        // Validasi: hanya bisa dihapus kalau status "Tersedia"
        if ($ruangan->status !== 'tersedia') {
            Alert::error('Gagal', 'Ruangan masih dipinjam dan tidak dapat dihapus');
            return redirect()->route('ruangan.index');
        }else{

        }

        $ruangan->delete();

        Alert::success('Success', 'Data berhasil dihapus')->autoClose(1000);
        return redirect()->route('ruangan.index');
    }

    public function updateStatusDipinjam($id)
    {
        $ruangan = Ruangan::findOrFail($id);

        if ($ruangan->status !== 'Dipinjam') {
            $ruangan->status = 'Dipinjam';
            $ruangan->save();

            Alert::success('Success', 'Status ruangan berhasil diubah menjadi Dipinjam');
        } else {
            Alert::warning('Warning', 'Ruangan sudah dipinjam');
        }

        return redirect()->route('ruangan.index');
    }

    public function updateStatusTersedia($id)
    {
        $ruangan = Ruangan::findOrFail($id);

        if ($ruangan->status === 'Dipinjam') {
            $ruangan->status = 'Tersedia';
            $ruangan->save();

            Alert::success('Success', 'Status ruangan berhasil diubah menjadi Tersedia');
        } else {
            Alert::warning('Warning', 'Ruangan tidak sedang dipinjam');
        }

        return redirect()->route('ruangan.index');
    }
}
