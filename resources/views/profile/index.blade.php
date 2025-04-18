@extends('layouts.admin')

@section('content')

<div class="container mt-5 pt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow-lg border-0 p-4" style="max-width: 600px; width: 100%; background-color: #f8faff; border-radius: 1rem;">

            {{-- Header Profile --}}
            <div class="d-flex align-items-center">
                @php
                    $initial = collect(explode(' ', $user->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->implode('');
                @endphp

                <div class="rounded-circle d-flex justify-content-center align-items-center shadow"
                     style="width: 80px; height: 80px; background-color: #007bff; color: white; font-size: 30px; font-weight: bold;">
                    {{ $initial }}
                </div>

                <div class="ms-3">
                    <p class="mb-1 text-muted" style="font-size: 14px;">Selamat datang kembali,</p>
                    <h4 class="fw-bold text-primary mb-0">{{ $user->name }}</h4>
                </div>
                <a href="#" class="ms-auto text-decoration-none text-primary" title="Edit Profil">
                    <i class="bi bi-pencil-square fs-5"></i>
                </a>
            </div>

            {{-- Info Table --}}
            <div class="card mt-4 p-3 border-0 shadow-sm" style="border-radius: 0.75rem; background-color: #ffffff;">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th class="text-muted" style="width: 40%;">Nama Pengguna</th>
                        <td>: <strong class="text-dark">{{ $user->name }}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Email</th>
                        <td>: <strong class="text-dark">{{ $user->email }}</strong></td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
