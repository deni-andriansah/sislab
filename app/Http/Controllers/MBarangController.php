<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\m_Barang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $m_barang = m_barang::all();
        confirmDelete('Delete', 'Are you sure?');
        return view('m_barang.index', compact('m_barang'));
    }

    public function create()
    {
        $barang = Barang::all();
        $ruangan = Ruangan::all();
        $codeMaintenance = 'MTN-' . Str::upper(Str::random(6)); // generate kode maintenance

        return view('m_barang.create', compact('barang', 'ruangan', 'codeMaintenance'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_maintenance' => 'required',
            'id_barang' => 'required',
            'id_ruangan' => 'required',
            'tanggal_maintenance' => 'required|date',
            'waktu_pengerjaan' => 'required',
            'jumlah' => 'required|integer',
            'keterangan' => 'required',
        ]);

        $m_barang = new m_barang();
        $m_barang->code_maintenance = $request->code_maintenance;
        $m_barang->id_barang = $request->id_barang;
        $m_barang->id_ruangan = $request->id_ruangan;
        $m_barang->tanggal_maintenance = $request->tanggal_maintenance;
        $m_barang->waktu_pengerjaan = $request->waktu_pengerjaan;
        $m_barang->jumlah = $request->jumlah;
        $m_barang->keterangan = $request->keterangan;
        $m_barang->save();

        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        return redirect()->route('m_barang.index');
    }

    public function show(m_barang $ruangan)
    {
        //
    }

    public function edit($id)
    {
        $ruangan = Ruangan::all();
        $barang = Barang::all();
        $m_barang = m_barang::findOrFail($id);
        return view('m_barang.edit', compact('m_barang', 'ruangan', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code_maintenance' => 'required',
            'id_barang' => 'required',
            'id_ruangan' => 'required',
            'tanggal_maintenance' => 'required|date',
            'waktu_pengerjaan' => 'required',
            'jumlah' => 'required|integer',
            'keterangan' => 'required',
        ]);

        $m_barang = m_barang::findOrFail($id);
        $m_barang->code_maintenance = $request->code_maintenance;
        $m_barang->id_barang = $request->id_barang;
        $m_barang->id_ruangan = $request->id_ruangan;
        $m_barang->tanggal_maintenance = $request->tanggal_maintenance;
        $m_barang->waktu_pengerjaan = $request->waktu_pengerjaan;
        $m_barang->jumlah = $request->jumlah;
        $m_barang->keterangan = $request->keterangan;
        $m_barang->save();

        Alert::success('Success', 'Data berhasil diubah')->autoClose(1000);
        return redirect()->route('m_barang.index');
    }

    public function destroy($id)
    {
        $m_barang = m_barang::findOrFail($id);
        $m_barang->delete();

        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('m_barang.index');
    }
}
