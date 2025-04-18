@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<style>
    .form-control {
        max-width: 300px;
    }
</style>
@endsection

@section('content')
<div class="container mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Pengembalian Barang</h5>
            <a href="{{ route('p_barang.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
        </div>

        <div class="card-body">
            <form action="{{ route('p_barang.update', $p_barang->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                    {{-- Dropdown untuk memilih barang yang dipinjam --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_pm_barang" class="form-label">Barang yang Dipinjam</label>
                            <select class="form-control" id="id_pm_barang" name="id_pm_barang" required>
                                @foreach($pm_barang as $item)
                                    <option
                                        value="{{ $item->id }}"
                                        data-tanggal="{{ $item->tanggal_pengembalian }}"
                                        {{ $item->id == $p_barang->id_pm_barang ? 'selected' : '' }}>
                                        {{ $item->code_peminjaman }} - {{ $item->anggota->nama_peminjam ?? 'Tanpa Nama' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tanggal Pengembalian --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                value="{{ \Carbon\Carbon::parse($p_barang->tanggal_selesai)->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <select class="form-control" id="keterangan" name="keterangan">
                                <option value="Baik" {{ $p_barang->keterangan == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak" {{ $p_barang->keterangan == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                <option value="Telat Dikembalikan" {{ $p_barang->keterangan == 'Telat Dikembalikan' ? 'selected' : '' }}>Telat Dikembalikan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Denda --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="denda" class="form-label">Denda (Rp)</label>
                            <input type="number" class="form-control" id="denda" name="denda" value="{{ old('denda', $denda) }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dendaField = document.getElementById('denda');
    const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
    const keteranganInput = document.getElementById('keterangan');
    const selectPeminjaman = document.getElementById('id_pm_barang');

    function hitungDenda() {
        const selectedOption = selectPeminjaman.options[selectPeminjaman.selectedIndex];
        const tanggalPengembalianStr = selectedOption.getAttribute('data-tanggal');
        const tanggalSelesaiStr = tanggalSelesaiInput.value;
        const keterangan = keteranganInput.value.toLowerCase();

        let denda = 0;

        if (tanggalPengembalianStr && tanggalSelesaiStr) {
            const tanggalPengembalian = new Date(tanggalPengembalianStr);
            const tanggalSelesai = new Date(tanggalSelesaiStr);

            if (tanggalSelesai > tanggalPengembalian) {
                const diffTime = tanggalSelesai - tanggalPengembalian;
                const daysLate = Math.ceil(diffTime / (1000 * 3600 * 24));
                denda += daysLate * 10000; // 10 ribu per hari keterlambatan
            }
        }

        if (keterangan.includes('rusak')) {
            denda += 5000; // Tambahan jika barang rusak
        }

        dendaField.value = denda;
    }

    tanggalSelesaiInput.addEventListener('change', hitungDenda);
    keteranganInput.addEventListener('input', hitungDenda);
    selectPeminjaman.addEventListener('change', hitungDenda);

    // Jalankan saat halaman dimuat
    window.addEventListener('DOMContentLoaded', hitungDenda);
</script>
@endpush
