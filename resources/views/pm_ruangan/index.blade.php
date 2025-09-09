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
            <h4>Peminjaman Ruangan</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Peminjaman Ruangan</h5>
            <a href="{{ route('pm_ruangan.create') }}" class="btn btn-sm btn-primary">Tambah</a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Peminjam</th>
                            <th>Nama Peminjam</th>
                            <th>Jenis Kegiatan</th>
                            <th>Nama Ruangan</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Waktu Peminjaman</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if(isset($pm_ruangan) && count($pm_ruangan) > 0)
                            @php $i = 1; @endphp
                            @foreach ($pm_ruangan as $data)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $data->code_peminjaman ?? '-' }}</td>
                                <td>{{ optional($data->anggota)->nama_peminjam ?? '-' }}</td>
                                <td>{{ $data->jenis_kegiatan ?? '-' }}</td>
                                <td>
                                    @if(isset($data->PeminjamanDetailRuangan) && count($data->PeminjamanDetailRuangan) > 0)
                                        @foreach ($data->PeminjamanDetailRuangan as $detail)
                                            <div class="mb-1">
                                                <span class="badge bg-primary">{{ optional($detail->ruangan)->nama_ruangan ?? 'Ruangan tidak ditemukan' }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $data->tanggal_peminjaman ?? '-' }}</td>
                                <td>{{ $data->tanggal_pengembalian ?? '-' }}</td>
                                <td>{{ $data->waktu_peminjaman ?? '-' }}</td>
                                <td>
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $data->id ?? $loop->index }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            ⋮
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $data->id ?? $loop->index }}">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('pm_ruangan.edit', $data->id) }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $data->id }})">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>Tidak ada data peminjaman ruangan</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{-- Form untuk delete dengan SweetAlert --}}
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
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Debug: Check column count
    const headerCols = $('#dataTable thead tr th').length;
    const bodyCols = $('#dataTable tbody tr:first td').length;
    console.log(`Header columns: ${headerCols}, Body columns: ${bodyCols}`);

    // Initialize DataTable only if table structure is correct
    if (headerCols > 0 && (bodyCols === headerCols || $('#dataTable tbody tr:first td[colspan]').length > 0)) {
        try {
            $('#dataTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Tidak ada data yang tersedia"
                },
                columnDefs: [
                    { targets: -1, orderable: false }, // Disable sorting on action column
                    { targets: 4, orderable: false }   // Disable sorting on ruangan column (complex content)
                ],
                order: [[0, 'asc']] // Default sort by No column
            });
        } catch (error) {
            console.error('DataTable initialization error:', error);
            // Show error message to user
            $('#dataTable').before('<div class="alert alert-warning">DataTable gagal diinisialisasi. Tabel akan ditampilkan dalam mode sederhana.</div>');
        }
    } else {
        console.error('Column count mismatch or empty table detected');
        $('#dataTable').before('<div class="alert alert-warning">Struktur tabel tidak valid untuk DataTable.</div>');
    }
});

function confirmDelete(id) {
    if (!id) {
        Swal.fire('Error!', 'ID tidak valid', 'error');
        return;
    }

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-form');
            form.action = `{{ url('pm_ruangan') }}/${id}`;
            form.submit();
        }
    });
}

// Handle success/error messages if passed from controller
@if(session('success'))
    Swal.fire('Berhasil!', '{{ session("success") }}', 'success');
@endif

@if(session('error'))
    Swal.fire('Error!', '{{ session("error") }}', 'error');
@endif
</script>
@endpush
