@extends('layouts.master')

@section('title', 'Kelola Pengguna')

@section('content')
    {{-- Menampilkan icon di tab --}}
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">

    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">


    <div class="container-fluid">
        {{-- Judul Halaman --}}
        <div class="mb-4 border-start border-4 border-dark ps-3">
            <h2 class="fw-semibold text-dark mb-1">
                <i class="bi bi-people-fill me-2"></i> Kelola Pengguna
            </h2>
            <small class="text-muted">Daftar admin yang memiliki akses ke sistem.</small>
        </div>

        {{-- Tombol Tambah --}}
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('kelolaPengguna.create') }}" class="btn btn-sm btn-dark shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Admin
            </a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Pengguna --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    @if (Auth::id() === $user->id)
                                        <a href="{{ route('kelolaPengguna.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled
                                            title="Hanya bisa edit akun sendiri">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x fs-4 text-secondary"></i><br>
                                    Belum ada pengguna yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
