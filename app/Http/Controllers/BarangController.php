<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        // Menggunakan eager loading untuk menghindari query berulang
        $barang = Barang::with('kategori')->get();
        confirmDelete('Delete', 'Are you sure?');

        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = Kategori::all();

        // Auto generate kode barang
        $last = Barang::latest()->first();
        $nextNumber = $last ? ((int)substr($last->code_barang, 3)) + 1 : 1;
        $code_barang = 'BRG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('barang.create', compact('kategori', 'code_barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_barang' => 'required',
            'nama_barang' => 'required',
            'merk' => 'required',
            'detail' => 'required',
            'jumlah' => 'required|integer|min:0',
            'id_kategori' => 'required',
        ]);

        Barang::create($validated);

        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        return redirect()->route('barang.index');
    }

    public function edit($id)
    {
        $kategori = Kategori::all();
        $barang = Barang::findOrFail($id);

        return view('barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code_barang' => 'required',
            'nama_barang' => 'required',
            'merk' => 'required',
            'detail' => 'required',
            'jumlah' => 'required|integer|min:0',
            'id_kategori' => 'required',
        ]);

        Barang::where('id', $id)->update($validated);

        Alert::success('Success', 'Data berhasil dirubah')->autoClose(1000);
        return redirect()->route('barang.index');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Cek apakah barang sedang dipinjam
        $isDipinjam = $barang->peminjaman_details()
            ->whereHas('pm_barang', function ($query) {
                $query->whereNotIn('code_peminjaman', function ($subQuery) {
                    $subQuery->select('code_peminjaman')->from('p_barangs');
                });
            })->exists();

        // Jika barang dipinjam, tampilkan pesan error dan blok penghapusan
        if ($isDipinjam) {
            Alert::error('Gagal Dihapus', 'Barang tidak bisa dihapus karena sedang dipinjam')->autoClose(3000);
            return redirect()->route('barang.index');
        }

        // Jika tidak ada peminjaman aktif, hapus barang
        $barang->delete();

        Alert::success('Berhasil', 'Barang berhasil dihapus')->autoClose(1000);
        return redirect()->route('barang.index');
    }

    public function reduceStock($id, $jumlah)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->jumlah < $jumlah) {
            throw new \Exception('Stok barang tidak cukup');
        }

        $barang->jumlah -= $jumlah;

        // Jika jumlah barang menjadi 0 atau kurang, set status menjadi "Tidak Tersedia"
        if ($barang->jumlah <= 0) {
            $barang->status = 'Tidak Tersedia';
            $barang->jumlah = 0; // Pastikan jumlah tidak negatif
        }

        $barang->save();

        return $barang;
    }

    public function addStock($id, $jumlah)
    {
        $barang = Barang::findOrFail($id);
        $barang->jumlah += $jumlah;

        // Jika jumlah barang lebih dari 0, set status menjadi "Tersedia"
        if ($barang->jumlah > 0) {
            $barang->status = 'Tersedia';
        }

        $barang->save();

        return $barang;
    }
}
