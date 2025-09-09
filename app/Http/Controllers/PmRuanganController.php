<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\pm_Ruangan;
use App\Models\Anggota;
use App\Models\PeminjamanDetailRuangan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class PmRuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pm_ruangan = pm_Ruangan::with('PeminjamanDetailRuangan.ruangan')->get();
        confirmDelete('Delete', 'Are you sure?');
        return view('pm_ruangan.index', compact('pm_ruangan'));
    }

    public function create()
    {
        $anggota = Anggota::all();
        $ruangan = Ruangan::all();
        return view('pm_ruangan.create', compact('anggota', 'ruangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_peminjaman' => 'required',
            'id_anggota' => 'required|exists:anggotas,id',
            'jenis_kegiatan' => 'required',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'waktu_peminjaman' => 'required',
            'id_ruangan' => 'required|array|min:1',
        ], [
            'code_peminjaman.required' => 'Kode peminjaman harus diisi!',
            'id_anggota.required' => 'Anggota peminjam harus dipilih!',
            'id_anggota.exists' => 'Anggota yang dipilih tidak valid!',
            'jenis_kegiatan.required' => 'Jenis kegiatan harus diisi!',
            'tanggal_peminjaman.required' => 'Tanggal peminjaman harus diisi!',
            'tanggal_pengembalian.required' => 'Tanggal pengembalian harus diisi!',
            'waktu_peminjaman.required' => 'Waktu peminjaman harus diisi!',
            'id_ruangan.required' => 'Ruangan harus dipilih!',
            'id_ruangan.array' => 'Pilih minimal satu ruangan!',
        ]);

        $pm_ruangan = new pm_Ruangan();
        $pm_ruangan->code_peminjaman = $request->code_peminjaman;
        $pm_ruangan->id_anggota = $request->id_anggota;
        $pm_ruangan->jenis_kegiatan = $request->jenis_kegiatan;
        $pm_ruangan->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_ruangan->tanggal_pengembalian = $request->tanggal_pengembalian;
        $pm_ruangan->waktu_peminjaman = $request->waktu_peminjaman;
        $pm_ruangan->save();

        foreach ($request->id_ruangan as $id_ruangan) {
            PeminjamanDetailRuangan::create([
                'id_pm_ruangan' => $pm_ruangan->id,
                'id_ruangan' => $id_ruangan,
            ]);

            // Update status ruangan menjadi tidak tersedia
            Ruangan::where('id', $id_ruangan)->update(['status' => 'Dipinjam']);
        }

        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        return redirect()->route('pm_ruangan.index');
    }

    public function edit($id)
    {
        $anggota = Anggota::all();
        $ruangan = Ruangan::all();
        $pm_ruangan = pm_Ruangan::findOrFail($id);
        $selectedRuangan = PeminjamanDetailRuangan::where('id_pm_ruangan', $id)->pluck('id_ruangan')->toArray();

        return view('pm_ruangan.edit', compact('pm_ruangan', 'anggota', 'ruangan', 'selectedRuangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code_peminjaman' => 'required',
            'id_anggota' => 'required|exists:anggotas,id',
            'jenis_kegiatan' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'waktu_peminjaman' => 'required',
            'id_ruangan' => 'required|array|min:1',
        ]);

        $pm_ruangan = pm_Ruangan::findOrFail($id);
        $pm_ruangan->code_peminjaman = $request->code_peminjaman;
        $pm_ruangan->id_anggota = $request->id_anggota;
        $pm_ruangan->jenis_kegiatan = $request->jenis_kegiatan;
        $pm_ruangan->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_ruangan->tanggal_pengembalian = $request->tanggal_pengembalian;
        $pm_ruangan->waktu_peminjaman = $request->waktu_peminjaman;
        $pm_ruangan->save();

        // Kembalikan status ruangan lama menjadi tersedia
        $ruanganLama = PeminjamanDetailRuangan::where('id_pm_ruangan', $id)->pluck('id_ruangan');
        Ruangan::whereIn('id', $ruanganLama)->update(['status' => 'tersedia']);

        // Hapus detail lama
        PeminjamanDetailRuangan::where('id_pm_ruangan', $id)->delete();

        // Tambah detail baru dan ubah status ruangan
        foreach ($request->id_ruangan as $id_ruangan) {
            PeminjamanDetailRuangan::create([
                'id_pm_ruangan' => $pm_ruangan->id,
                'id_ruangan' => $id_ruangan,
            ]);

            // Ubah status ruangan menjadi tidak tersedia
            Ruangan::where('id', $id_ruangan)->update(['status' => 'tidak tersedia']);
        }

        Alert::success('Success', 'Data berhasil diperbarui')->autoClose(1000);
        return redirect()->route('pm_ruangan.index');
    }

    public function destroy($id)
    {
        $pm_ruangan = pm_Ruangan::findOrFail($id);

        // Kembalikan status ruangan menjadi tersedia
        $ruanganDipinjam = PeminjamanDetailRuangan::where('id_pm_ruangan', $id)->pluck('id_ruangan');
        Ruangan::whereIn('id', $ruanganDipinjam)->update(['status' => 'tersedia']);

        // Hapus detail peminjaman
        PeminjamanDetailRuangan::where('id_pm_ruangan', $id)->delete();

        // Hapus peminjaman
        $pm_ruangan->delete();
        $pm_ruangan->save();

        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('pm_ruangan.index');
    }
}
