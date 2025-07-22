@extends('layouts.master')

@section('title', 'Tambah Admin')

@section('content')
    {{-- Menampilkan icon di tab --}}
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">

    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <div class="container">
        <div class="mb-4 border-start border-4 border-dark ps-3">
            <h2 class="fw-semibold text-dark mb-1">
                <i class="bi bi-person-plus-fill me-2"></i> Tambah Admin
            </h2>
            <small class="text-muted">Masukkan informasi untuk admin baru.</small>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('kelolaPengguna.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            required>
                    </div>
                    <a href="{{ route('kelolaPengguna') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-dark">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
