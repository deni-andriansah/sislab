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
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Peminjam</th>
                        <th>Nama Peminjam</th>
                        <th>Jenis kegiatan</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Pinjam</th>
                        <th>Nama Ruangan</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Waktu Peminjaman</th>
                        <th>serah terima </th>
                        <th>berita peminjaman</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php $i = 1; @endphp
                    @foreach ($pm_barang as $data)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $data->code_peminjaman }}</td>
                        <td>{{ $data->anggota->nama_peminjam }}</td>
                        <td>{{ $data->jenis_kegiatan }}</td>
                         <td>
                        <ul>
                            @foreach ($data->peminjaman_details as $detail)
                            <li>{{ $detail->barang->nama_barang }} </li>
                            @endforeach
                        </ul>
                    </td>
                     <td>
                        <ul>
                            @foreach ($data->peminjaman_details as $detail)
                            <li> {{ $detail->jumlah_pinjam }} Pcs</li>
                            @endforeach
                        </ul>
                    </td>

                        <td>{{$data->ruangan->nama_ruangan}}</td>
                        <td>{{ $data->tanggal_peminjaman }}</td>
                        <td>{{ $data->waktu_peminjaman }}</td>

<!-- Tombol untuk membuka modal -->
<td class="button">
    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#pdfModal-{{ $data->id }}">
        Cetak
    </button>
</td>

<!-- Modal untuk menampilkan PDF -->
<div class="modal fade" id="pdfModal-{{ $data->id }}" tabindex="-1" aria-labelledby="pdfModalLabel-{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel-{{ $data->id }}">Menampilkan surat berita acara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Iframe untuk menampilkan PDF -->
                <iframe src="{{ route('pm_barang.view-pdf', $data->id) }}" width="100%" height="500px" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>
<td class="button">
    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#pdfModal2-{{ $data->id }}">
        Cetak
    </button>
</td>

<!-- Modal untuk menampilkan PDF -->
<div class="modal fade" id="pdfModal2-{{ $data->id }}" tabindex="-1" aria-labelledby="pdfModalLabel-{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel-{{ $data->id }}">Menampilkan surat serah terima</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Iframe untuk menampilkan PDF -->
                <iframe src="{{ route('pm_barang.view-barang', $data->id) }}" width="100%" height="500px" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>



                        <<td>
                        <div class="dropdown d-inline">
    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        ⋮
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li>
            <a class="dropdown-item" href="{{ route('pm_barang.edit', $data->id) }}">✏ Edit</a>
        </li>
        <li>
            <form action="{{ route('pm_barang.destroy', $data->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Yakin ingin menghapus?')">🗑 Hapus</button>
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

@push('scripts')
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

<script>
    new DataTable('#dataTable');
</script>
@endpush
