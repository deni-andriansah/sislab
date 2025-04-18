<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\m_Ruangan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Str;  // Import Str class untuk generate random string

class MRuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $m_ruangan = m_ruangan::all();
        confirmDelete('Delete','Are you sure?');
        return view('m_ruangan.index', compact('m_ruangan'));
    }

    public function create()
    {
        $ruangan = Ruangan::all();
        $codeMaintenance = 'MAINT-' . Str::upper(Str::random(8));  // Generate random code_maintenance
        return view('m_ruangan.create', compact('ruangan', 'codeMaintenance')); // Pass code_maintenance to view
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal_maintenance' => 'required',
            'waktu_pengerjaan' => 'required',
            'keterangan' => 'required',
        ]);

        // Create new maintenance record
        $m_ruangan = new m_ruangan();
        $m_ruangan->code_maintenance = $request->code_maintenance;  // Using the code from the form
        $m_ruangan->id_ruangan = $request->id_ruangan;
        $m_ruangan->tanggal_maintenance = $request->tanggal_maintenance;
        $m_ruangan->waktu_pengerjaan = $request->waktu_pengerjaan;
        $m_ruangan->keterangan = $request->keterangan;

        // Success message and save the data
        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        $m_ruangan->save();

        return redirect()->route('m_ruangan.index');
    }

    public function show(m_ruangan $ruangan)
    {
        //
    }

    public function edit($id)
    {
        $ruangan = Ruangan::all();
        $m_ruangan = m_ruangan::findOrFail($id);
        return view('m_ruangan.edit', compact('m_ruangan', 'ruangan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $this->validate($request, [
            'tanggal_maintenance' => 'required',
            'waktu_pengerjaan' => 'required',
            'keterangan' => 'required',
        ]);

        $m_ruangan = m_ruangan::findOrFail($id);

        // Keep the code_maintenance unchanged during update
        $m_ruangan->id_ruangan = $request->id_ruangan;
        $m_ruangan->tanggal_maintenance = $request->tanggal_maintenance;
        $m_ruangan->waktu_pengerjaan = $request->waktu_pengerjaan;
        $m_ruangan->keterangan = $request->keterangan;

        // Success message and save the data
        Alert::success('Success', 'Data berhasil diubah')->autoClose(1000);
        $m_ruangan->save();

        return redirect()->route('m_ruangan.index');
    }

    public function destroy($id)
    {
        $m_ruangan = m_ruangan::findOrFail($id);
        $m_ruangan->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('m_ruangan.index');
    }
}
