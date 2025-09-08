<?php

namespace App\Http\Controllers;

use App\Models\anggota;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $anggota = anggota::all();
        confirmDelete('Delete', 'Are you sure?');
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:anggotas,nim',
            'nama_peminjam' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'required',
            'instansi_lembaga' => 'required',
        ]);

        $anggota = new anggota();
        $anggota->nim = $request->nim;
        $anggota->nama_peminjam = $request->nama_peminjam;
        $anggota->email = $request->email;
        $anggota->no_telepon = $request->no_telepon;
        $anggota->instansi_lembaga = $request->instansi_lembaga;
        $anggota->save();

        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        return redirect()->route('anggota.index');
    }

    public function edit($id)
    {
        $anggota = anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:anggotas,nim,' . $id,
            'nama_peminjam' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'required',
            'instansi_lembaga' => 'required',
        ]);

        $anggota = anggota::findOrFail($id);
        $anggota->nim = $request->nim;
        $anggota->nama_peminjam = $request->nama_peminjam;
        $anggota->email = $request->email;
        $anggota->no_telepon = $request->no_telepon;
        $anggota->instansi_lembaga = $request->instansi_lembaga;
        $anggota->save();

        Alert::success('Success', 'Data berhasil diubah')->autoClose(1000);
        return redirect()->route('anggota.index');
    }

    public function destroy($id)
    {
        $anggota = anggota::findOrFail($id);

        // Cek apakah anggota masih memiliki peminjaman barang atau ruangan
        if ($anggota->pm_barang()->exists() || $anggota->pm_ruangan()->exists()) {
            Alert::error('Gagal', 'Anggota masih memiliki peminjaman dan tidak dapat dihapus!');
            return redirect()->route('anggota.index');
        }

        $anggota->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('anggota.index');
    }
}
