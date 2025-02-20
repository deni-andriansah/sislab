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
            <h5>Pengembalian Barang</h5>
        </div>
        <div class="float-end ">
            <a href="{{ route('p_barang.create') }}" class="btn btn-sm btn-primary">Add</a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table" id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kose Peminjam</th>
                        <th>Nama Pengembali</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php $i = 1; @endphp
                    @foreach ($p_barang as $data)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $data->pm_barang->code_peminjaman}}</td>
                        <td>{{ $data->nama_pengembali }}</td>
                        <td>{{ $data->tanggal_pengembalian }}</td>
                        <td>{{ $data->keterangan }}</td>

                        <td  style="width: 1000px">
                            <form action="{{ route('p_barang.destroy', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('p_barang.edit', $data->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a> |
                                <a href="{{ route('p_barang.destroy', $data->id)}}"
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
