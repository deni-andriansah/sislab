@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
@endsection

@section('content')
<div class="container mt-10">
    <div class="row page-titles mx-0">
        <div class="col-sm-12 p-md-0">
              </div>
    </div>
</div>
<div class="container">


<div class="card">
    <div class="card-header">
        <div class="float-start">
            <h5>Peminjaman Barang</h5>
        </div>
        <div class="float-end ">
            <a href="{{ route('pm_barang.create') }}" class="btn btn-sm btn-primary">Add</a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table" id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Email</th>
                        <th>Instansi</th>
                        <th>Nama Barang</th>
                        <th>Nama Ruangan</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Keterangan</th>
                        <th>Kondisi</th>
                        <th>Dokumentasi</th>
                        <th>serah terima</th>
                        <th>berita peminjaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php $i = 1; @endphp
                    @foreach ($pm_barang as $data)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $data->nama_peminjam }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->instansi }}</td>
                        <td>{{$data->barang->nama_barang}}</td>
                        <td>{{$data->ruangan->nama_ruangan}}</td>
                        <td>{{ $data->tanggal_peminjaman }}</td>
                        <td>{{ $data->tanggal_pengembalian }}</td>
                        <td>{{ $data->keterangan }}</td>
                        <td>{{$data->kondisi->kondisi}}</td>
                        <td>
                            <img src="{{ asset('/images/pm_barang/' . $data->cover) }}"
                                style="width: 150px">
                        </td>


                        <td>
                            <form action="{{ route('pm_barang.view-pdf') }}" method="post">
                                @csrf

                                <button type="submit" class="btn text-light btn-sm btn-success">Cetak surat</button>
                            </form>

                        </td>
                        <td>
                            <form action="" method="post">
                                @csrf

                                <button type="submit" class="btn text-light btn-sm btn-success">Cetak surat</button>
                            </form>

                        </td>

                        <td style="width: 10000px">
                            <form action="{{ route('pm_barang.destroy', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('pm_barang.edit', $data->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a> |
                                <a href="{{ route('pm_barang.destroy', $data->id)}}"
                                     class="btn btn-sm btn-danger" data-confirm-delete="true">Delete</a>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script>
    new DataTable('#example');
</script>
@endpush
