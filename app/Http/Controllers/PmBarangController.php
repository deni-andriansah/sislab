<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Ruangan;
use App\Models\pm_barang;
use App\Models\peminjaman_detail;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class PmBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pm_barang = pm_barang::all();
        confirmDelete('Delete', 'Are you sure?');
        return view('pm_barang.index', compact('pm_barang'));
    }

    public function create()
    {
        $barang = Barang::all();
        $ruangan = Ruangan::all();
        $anggota = Anggota::all();
        return view('pm_barang.create', compact('barang', 'ruangan', 'anggota'));
    }

  public function store(Request $request)
{
    $validated = $request->validate([
        'jenis_kegiatan' => 'required',
        'id_barang' => 'required|array',
        'jumlah_pinjam' => 'required|array',
        'jumlah_pinjam.*' => 'integer|min:1',
        'tanggal_peminjaman' => 'required|date',
        'waktu_peminjaman' => 'required',
    ]);

    $codePeminjaman = 'PM-' . date('Ymd') . '-' . mt_rand(1000, 9999);

    $pm_barang = new pm_barang();
    $pm_barang->code_peminjaman = $codePeminjaman;
    $pm_barang->id_anggota = $request->id_anggota;
    $pm_barang->jenis_kegiatan = $request->jenis_kegiatan;
    $pm_barang->id_ruangan = $request->id_ruangan;
    $pm_barang->tanggal_peminjaman = $request->tanggal_peminjaman;
    $pm_barang->waktu_peminjaman = $request->waktu_peminjaman;
    $pm_barang->save();

    foreach ($request->id_barang as $index => $id_barang) {
        $barang = Barang::findOrFail($id_barang);

        if ($barang->jumlah < $request->jumlah_pinjam[$index]) {
            Alert::error('Error', 'Stok barang tidak mencukupi!')->autoClose(2000);
            return redirect()->back();
        }

        $barang->jumlah -= $request->jumlah_pinjam[$index];
        $barang->save();

        $peminjaman_detail = new peminjaman_detail();
        $peminjaman_detail->id_pm_barang = $pm_barang->id;
        $peminjaman_detail->id_barang = $id_barang;
        $peminjaman_detail->jumlah_pinjam = $request->jumlah_pinjam[$index];
        $peminjaman_detail->save();
    }

    Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
    return redirect()->route('pm_barang.index');
}

    public function edit($id)
    {
        $barang = Barang::all();
        $ruangan = Ruangan::all();
        $anggota = Anggota::all();
        $pm_barang = pm_barang::where('code_peminjaman', $id)->get();
        return view('pm_barang.edit', compact('pm_barang', 'barang', 'ruangan', 'anggota'));
    }

    public function update(Request $request, $id)
    {
        $pm_barang = pm_barang::where('code_peminjaman', $id)->get();

        foreach ($pm_barang as $item) {
            $barangLama = Barang::findOrFail($item->id_barang);
            $barangLama->jumlah += $item->jumlah_pinjam;
            $barangLama->save();
            $item->delete();
        }

        return $this->store($request);
    }


    public function destroy($id)
    {
        $pm_barang = pm_barang::findOrFail($id);
        $barang = Barang::findOrFail($pm_barang->id_barang);

        // Kembalikan stok barang sebelum dihapus
        $barang->jumlah += $pm_barang->jumlah_pinjam;
        $barang->save();

        $pm_barang->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('pm_barang.index');
    }
}
