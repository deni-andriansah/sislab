@extends('layouts.admin')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Maintenance Barang') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('m_barang.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('m_barang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Code Maintenance -->
                        <div class="mb-2">
                            <label class="form-label">Code Maintenance</label>
                            <input type="text" class="form-control @error('code_maintenance') is-invalid @enderror"
                                   name="code_maintenance"
                                   value="{{ old('code_maintenance', $codeMaintenance) }}"
                                   placeholder="code maintenance" required readonly>
                            @error('code_maintenance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label for="">Nama Barang</label>
                            <select name="id_barang" class="form-control">
                                @foreach ($barang as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Ruangan -->
                        <div class="mb-3">
                            <label for="">Nama Ruangan</label>
                            <select name="id_ruangan" class="form-control">
                                @foreach ($ruangan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Maintenance -->
                        <div class="mb-2">
                            <label class="form-label">Tanggal Maintenance</label>
                            <input type="date" class="form-control @error('tanggal_maintenance') is-invalid @enderror"
                                   name="tanggal_maintenance"
                                   value="{{ old('tanggal_maintenance') }}"
                                   placeholder="tanggal maintenance" required>
                            @error('tanggal_maintenance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Waktu Pengerjaan -->
                        <div class="mb-2">
                            <label class="form-label">Waktu Pengerjaan</label>
                            <input type="text" class="form-control @error('waktu_pengerjaan') is-invalid @enderror"
                                   name="waktu_pengerjaan"
                                   value="{{ old('waktu_pengerjaan') }}"
                                   placeholder="waktu pengerjaan" required>
                            @error('waktu_pengerjaan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-2">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                   name="jumlah"
                                   value="{{ old('jumlah') }}"
                                   placeholder="jumlah" required>
                            @error('jumlah')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-2">
                            <label class="form-label">Keterangan</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                   name="keterangan"
                                   value="{{ old('keterangan') }}"
                                   placeholder="keterangan" required>
                            @error('keterangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <br>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
