@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">

<style>
    .table thead {
        background-color: #ffffff !important;
        color: #000 !important;
    }
    .table tbody tr:hover {
        background-color: transparent !important;
    }
</style>
@endsection

@section('content')
<div class="container mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pengembalian Ruangan</h5>
            <a href="{{ route('p_ruangan.create') }}" class="btn btn-sm btn-primary">Tambah</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="example">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Pengembalian</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Keterangan</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($p_ruangan as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            {{-- tampilkan kode kalau ada, kalau tidak generate otomatis --}}
                            <td>
                                {{ $data->kode_pengembalian ?? 'KEMB-' . str_pad($data->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('d M Y') }}</td>
                            <td>{{ $data->keterangan ?? '-' }}</td>
                            <td>
                                @php
                                    $denda = 0;
                                    if ($data->keterangan && strpos(strtolower($data->keterangan), 'rusak') !== false) {
                                        $denda = 5000;
                                    }
                                    $pm_ruangan = $data->pm_ruangan;
                                    if ($pm_ruangan) {
                                        $tanggal_pengembalian = \Carbon\Carbon::parse($pm_ruangan->tanggal_pengembalian);
                                        $tanggal_selesai = \Carbon\Carbon::parse($data->tanggal_selesai);
                                        if ($tanggal_selesai->greaterThan($tanggal_pengembalian)) {
                                            $daysLate = $tanggal_pengembalian->diffInDays($tanggal_selesai);
                                            $denda += $daysLate * 10000;
                                        }
                                    }
                                @endphp
                                Rp. {{ number_format($denda, 0, ',', '.') }}
                            </td>
                            <td>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        ⋮
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('p_ruangan.edit', $data->id) }}">✏ Edit</a>
                                        </li>
                                        <li>
                                            <button type="button" onclick="confirmDelete({{ $data->id }})" class="dropdown-item text-danger">🗑 Hapus</button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <form id="delete-form" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example');

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = "{{ url('p_ruangan') }}/" + id;
                form.submit();
            }
        });
    }
</script>
@endpush
