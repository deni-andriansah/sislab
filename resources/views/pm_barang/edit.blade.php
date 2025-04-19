@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Peminjaman Barang</h5>
                    <a href="{{ route('pm_barang.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('pm_barang.update', $pm_barang->code_peminjaman) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" value="{{ $pm_barang->anggota->nim }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Peminjam</label>
                            <input type="hidden" name="id_anggota" value="{{ $pm_barang->anggota->id }}">
                            <input type="text" class="form-control" value="{{ $pm_barang->anggota->nama_peminjam }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kegiatan</label>
                            <input type="text" name="jenis_kegiatan" class="form-control" value="{{ $pm_barang->jenis_kegiatan }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ruangan</label>
                            <select name="id_ruangan" class="form-select" required>
                                <option value="">Pilih Ruangan</option>
                                @foreach($ruangan as $r)
                                    <option value="{{ $r->id }}" {{ $r->id == $pm_barang->id_ruangan ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Peminjaman</label>
                                <input type="date" name="tanggal_peminjaman" class="form-control" value="{{ $pm_barang->tanggal_peminjaman }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Pengembalian</label>
                                <input type="date" name="tanggal_pengembalian" class="form-control" value="{{ $pm_barang->tanggal_pengembalian }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Waktu Peminjaman</label>
                            <input type="time" name="waktu_peminjaman" class="form-control" value="{{ $pm_barang->waktu_peminjaman }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Barang yang Dipinjam</label>
                            <table class="table table-bordered" id="barang-table">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($details as $index => $detail)
                                    <tr class="barang-row">
                                        <td>
                                            <select name="id_barang[]" class="form-select" required>
                                                <option value="">Pilih Barang</option>
                                                @foreach($barang as $b)
                                                    <option value="{{ $b->id }}" {{ $b->id == $detail->id_barang ? 'selected' : '' }}>{{ $b->nama_barang }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="jumlah_pinjam[]" class="form-control" min="1" value="{{ $detail->jumlah_pinjam }}" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-barang">Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-success" id="add-barang">+ Tambah Barang</button>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Template baris barang baru --}}
<template id="barang-template">
    <tr class="barang-row">
        <td>
            <select name="id_barang[]" class="form-select" required>
                <option value="">Pilih Barang</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="jumlah_pinjam[]" class="form-control" min="1" required>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm remove-barang">Hapus</button>
        </td>
    </tr>
</template>

@endsection

@push('scripts')
<script>
    document.getElementById('add-barang').addEventListener('click', function () {
        const template = document.getElementById('barang-template').content.cloneNode(true);
        document.querySelector('#barang-table tbody').appendChild(template);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-barang')) {
            e.target.closest('.barang-row').remove();
        }
    });
</script>
@endpush
