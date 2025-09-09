@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <style>
        .form-control {
            max-width: 350px;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Form Pengembalian Barang</h5>
                <a href="{{ route('p_barang.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
            </div>

            <div class="card-body">
                <form action="{{ route('p_barang.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        {{-- Pilih Peminjaman --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_pm_barang" class="form-label">Pilih Peminjaman</label>
                                <select class="form-control" id="id_pm_barang" name="id_pm_barang" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($pm_barang as $item)
                                        <option value="{{ $item->id }}"
                                            data-tanggal="{{ $item->tanggal_pengembalian }}">
                                            {{ $item->code_peminjaman }} -
                                            {{ $item->anggota->nama_peminjam ?? 'Tanpa Nama' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Tanggal Selesai Pengembalian --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                    value="{{ old('tanggal_selesai') }}" required>
                            </div>
                        </div>

                        {{-- Kondisi Barang --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Kondisi Barang</label>
                                <select class="form-control" id="keterangan" name="keterangan">
                                    <option value="Baik" {{ old('keterangan') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak" {{ old('keterangan') == 'Rusak' ? 'selected' : '' }}>Rusak
                                    </option>
                                    <option value="Telat Dikembalikan"
                                        {{ old('keterangan') == 'Telat Dikembalikan' ? 'selected' : '' }}>Telat</option>
                                </select>
                            </div>
                        </div>

                        {{-- Denda --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="denda" class="form-label">Denda</label>
                                <input type="text" class="form-control" id="denda" name="denda" value="Rp 0"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Setting Denda (opsional bisa ditaruh di tabel setting / config DB) --}}
                    <div class="alert alert-info small">
                        <strong>Info:</strong> Denda dihitung otomatis:
                        <ul class="mb-0">
                            <li>Rp <span id="dendaPerHari">10.000</span> / hari keterlambatan</li>
                            <li>Rp <span id="dendaRusak">50.000</span> jika barang rusak</li>
                        </ul>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @push('scripts')
        <script>
            const dendaField = document.getElementById('denda');
            const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
            const keteranganInput = document.getElementById('keterangan');
            const selectPeminjaman = document.getElementById('id_pm_barang');

            // Atur nominal denda disini (bisa diambil dari database nantinya)
            const DENDA_PER_HARI = 10000; // Rp 10.000 per hari
            const DENDA_RUSAK = 50000; // Rp 50.000 kalau rusak

            function hitungDenda() {
                const selectedOption = selectPeminjaman.options[selectPeminjaman.selectedIndex];
                if (!selectedOption) return;

                const tanggalPengembalian = new Date(selectedOption.getAttribute('data-tanggal'));
                const tanggalSelesai = new Date(tanggalSelesaiInput.value);
                const keterangan = keteranganInput.value;

                let denda = 0;

                // Hitung keterlambatan
                if (tanggalSelesai && tanggalSelesai > tanggalPengembalian) {
                    const diffTime = tanggalSelesai - tanggalPengembalian;
                    const daysLate = Math.ceil(diffTime / (1000 * 3600 * 24));
                    denda += daysLate * DENDA_PER_HARI;
                }

                // Tambahan jika rusak
                if (keterangan === 'Rusak') {
                    denda += DENDA_RUSAK;
                }

                dendaField.value = denda > 0 ? "Rp " + denda.toLocaleString('id-ID') : "Rp 0";
            }

            tanggalSelesaiInput.addEventListener('change', hitungDenda);
            keteranganInput.addEventListener('change', hitungDenda);
            selectPeminjaman.addEventListener('change', hitungDenda);
        </script>
    @endpush
@endpush
