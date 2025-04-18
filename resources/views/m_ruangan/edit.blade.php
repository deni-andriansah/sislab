@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Edit Maintenance Ruangan') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('m_ruangan.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('m_ruangan.update', $m_ruangan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Menampilkan code_maintenance yang tidak dapat diubah -->
                        <div class="mb-2">
                            <label class="form-label">Code Maintenance</label>
                            <input type="text" class="form-control @error('code_maintenance') is-invalid @enderror" name="code_maintenance"
                                value="{{ old('code_maintenance', $m_ruangan->code_maintenance) }}" required readonly>
                            @error('code_maintenance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Form Nama Ruangan -->
                        <div class="mb-3">
                            <label for="id_ruangan" class="form-label">Nama Ruangan</label>
                            <select name="id_ruangan" id="id_ruangan" class="form-control @error('id_ruangan') is-invalid @enderror">
                                @foreach ($ruangan as $data)
                                    <option value="{{ $data->id }}" {{ $m_ruangan->id_ruangan == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_ruangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Form Tanggal Maintenance -->
                        <div class="mb-2">
                            <label class="form-label">Tanggal Maintenance</label>
                            <input type="date" class="form-control @error('tanggal_maintenance') is-invalid @enderror" name="tanggal_maintenance"
                                value="{{ old('tanggal_maintenance', $m_ruangan->tanggal_maintenance) }}" required>
                            @error('tanggal_maintenance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Form Waktu Pengerjaan -->
                        <div class="mb-2">
                            <label class="form-label">Waktu Pengerjaan</label>
                            <input type="text" class="form-control @error('waktu_pengerjaan') is-invalid @enderror" name="waktu_pengerjaan"
                                value="{{ old('waktu_pengerjaan', $m_ruangan->waktu_pengerjaan) }}" required>
                            @error('waktu_pengerjaan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Form Keterangan -->
                        <div class="mb-2">
                            <label class="form-label">Keterangan</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                                value="{{ old('keterangan', $m_ruangan->keterangan) }}" required>
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
