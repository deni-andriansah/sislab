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
            <h5>Peminjaman Ruangan</h5>
        </div>
        <div class="float-end ">
            <a href="{{ route('pm_ruangan.create') }}" class="btn btn-sm btn-primary">Add</a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table" id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Peminjaman</th>
                        <th>Nama Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Jenis Kegiatan</th>
                        <th>Waktu Peminjaman</th>
                        <th>Dokumentasi</th>
                        <th>serah terima</th>
                        <th>berita peminjaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php $i = 1; @endphp
                    @foreach ($pm_ruangan as $data)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $data->code_peminjaman }}</td>
                        <td>{{$data->anggota->nama_peminjam}}</td>
                        <td>{{$data->ruangan->nama_ruangan}}</td>
                        <td>{{ $data->tanggal_peminjaman }}</td>
                        <td>{{$data->jenis_kegiatan}}</td>
                        <td>{{ $data->waktu_peminjaman }}</td>
                        <td>
                            <img src="{{ asset('/images/pm_ruangan/' . $data->cover) }}"
                                style="width: 150px">
                        </td>

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
                                    <iframe src="{{ route('pm_ruangan.view-pdf', $data->id) }}" width="100%" height="500px" frameborder="0"></iframe>
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
                        <div class="modal fade" id="pdfModal2-{{ $data->id }}" tabindex="-1" aria-labelledby="pdfModalLabel-{{ $data->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pdfModalLabel-{{ $data->id }}">Menampilkan surat berita acara</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Iframe untuk menampilkan PDF -->
                                        <iframe src="{{ route('pm_ruangan.view-ruangan', $data->id) }}" width="100%" height="500px" frameborder="0"></iframe>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <td style="width: 10000px">
                            <form action="{{ route('pm_ruangan.destroy', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('pm_ruangan.edit', $data->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('pm_ruangan.destroy', $data->id)}}"
                                     class="btn btn-sm btn-danger mt-2" data-confirm-delete="true">Delete</a>
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
