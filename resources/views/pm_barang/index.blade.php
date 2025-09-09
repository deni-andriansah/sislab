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
    <div class="row page-titles mx-0">
        <div class="col-sm-12 p-md-0">
            <h4>Peminjaman Barang</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Peminjaman Barang</h5>
            <a href="{{ route('pm_barang.create') }}" class="btn btn-sm btn-primary">Tambah</a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Peminjam</th>
                            <th>NIM</th>
                            <th>Nama Peminjam</th>
                            <th>Jenis Kegiatan</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Pinjam</th>
                            <th>Nama Ruangan</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Waktu Peminjaman</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if($pm_barang && count($pm_barang) > 0)
                            @php $i = 1; @endphp
                            @foreach ($pm_barang as $data)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $data->code_peminjaman ?? '-' }}</td>
                                <td>{{ $data->anggota->nim ?? '-' }}</td>
                                <td>{{ $data->anggota->nama_peminjam ?? '-' }}</td>
                                <td>{{ $data->jenis_kegiatan ?? '-' }}</td>
                                <td>
                                    @if(isset($data->peminjaman_details) && count($data->peminjaman_details) > 0)
                                        @foreach ($data->peminjaman_details as $detail)
                                            <div>{{ $detail->barang->nama_barang ?? '-' }}</div>
                                        @endforeach
                                    @else
                                        <div>-</div>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($data->peminjaman_details) && count($data->peminjaman_details) > 0)
                                        @foreach ($data->peminjaman_details as $detail)
                                            <div>{{ $detail->jumlah_pinjam ?? 0 }} Pcs</div>
                                        @endforeach
                                    @else
                                        <div>0 Pcs</div>
                                    @endif
                                </td>
                                <td>{{ $data->ruangan->nama_ruangan ?? '-' }}</td>
                                <td>{{ $data->tanggal_peminjaman ?? '-' }}</td>
                                <td>{{ $data->tanggal_pengembalian ?? '-' }}</td>
                                <td>{{ $data->waktu_peminjaman ?? '-' }}</td>
                                <td>
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $data->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            ⋮
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $data->id }}">
                                            <li>
                                                <a href="{{ route('pm_barang.edit', $data->code_peminjaman) }}" class="dropdown-item">✏ Edit</a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $data->id }})">🗑 Hapus</button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12" class="text-center">Tidak ada data peminjaman barang</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{-- Form penghapusan --}}
                <form id="delete-form" method="POST" style="display:none;">
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
    new DataTable('#dataTable');

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = `{{ url('pm_barang') }}/${id}`;
                form.submit();
            }
        });
    }
</script>
@endpush
