@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Edit Anggota') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim"
                                value="{{ old('nim', $anggota->nim) }}" placeholder="Masukkan NIM" required>
                            @error('nim')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Nama Peminjam</label>
                            <input type="text" class="form-control @error('nama_peminjam') is-invalid @enderror" name="nama_peminjam"
                                value="{{ old('nama_peminjam', $anggota->nama_peminjam) }}" placeholder="Nama peminjam" required>
                            @error('nama_peminjam')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email', $anggota->email) }}" placeholder="Email" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Nomer Telepon</label>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon"
                                value="{{ old('no_telepon', $anggota->no_telepon) }}" placeholder="Nomer telepon" required>
                            @error('no_telepon')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Instansi Lembaga</label>
                            <input type="text" class="form-control @error('instansi_lembaga') is-invalid @enderror" name="instansi_lembaga"
                                value="{{ old('instansi_lembaga', $anggota->instansi_lembaga) }}" placeholder="Instansi Lembaga" required>
                            @error('instansi_lembaga')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <br>
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
