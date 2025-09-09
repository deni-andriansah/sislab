@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
@endsection

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Ruangan</h5>
            <a href="{{ route('ruangan.create') }}" class="btn btn-sm btn-primary">Add</a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Nama PIC</th>
                            <th>Posisi Ruangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($ruangan as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->nama_ruangan }}</td>
                            <td>{{ $data->nama_pic }}</td>
                            <td>{{ $data->posisi_ruangan }}</td>
                            <td>
                                @if($data->status === 'Dipinjam')
                                    <span class="badge bg-danger">Dipinjam</span>
                                @else
                                    <span class="badge bg-success">Tersedia</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown">
                                        ⋮
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('ruangan.edit', $data->id) }}">✏ Edit</a>
                                        </li>
                                        <li>
                                            <form action="{{ route('ruangan.destroy', $data->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin mau hapus ruangan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    🗑 Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
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

@section('scripts')
<script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
@endsection
