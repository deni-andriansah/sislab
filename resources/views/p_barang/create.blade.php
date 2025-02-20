@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Pengembalian Barang') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('p_barang.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('p_barang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="">Kode Peminjaman</label>
                            <select name="id_pm_barang" id="" class="form-control">
                                @foreach ($pm_barang as $data)
                                    <option value="{{$data->id}}">{{  $data->code_peminjaman}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Nama Pengembali</label>
                            <input type="text" class="form-control @error('nama_pengembali') is-invalid @enderror" name="nama_pengembali"
                            value="{{ old('nama_pengembali') }}" placeholder="Nama Pengembali" required>
                            @error('nama_pengembali')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control @error('tanggal_pengembalian') is-invalid @enderror" name="tanggal_pengembalian"
                            value="{{ old('tanggal_pengembalian') }}" placeholder="Tanggal Pengembalian" required>
                            @error('tanggal_pengembalian')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Keterangan</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                            value="{{ old('keterangan') }}" placeholder="Keterangan" required>
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
