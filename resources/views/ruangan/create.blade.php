@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Tambah Ruangan') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('ruangan.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('ruangan.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Nama Ruangan</label>
                            <input type="text" class="form-control @error('nama_ruangan') is-invalid @enderror" name="nama_ruangan"
                            value="{{ old('nama_ruangan') }}" placeholder="Nama ruangan" required>
                            @error('nama_ruangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Nama PIC</label>
                            <input type="text" class="form-control @error('nama_pic') is-invalid @enderror" name="nama_pic"
                            value="{{ old('nama_pic') }}" placeholder="Nama PIC" required>
                            @error('nama_pic')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Posisi Ruangan</label>
                            <input type="text" class="form-control @error('posisi_ruangan') is-invalid @enderror" name="posisi_ruangan"
                            value="{{ old('posisi_ruangan') }}" placeholder="Posisi ruangan" required>
                            @error('posisi_ruangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
