@extends('layouts.master')

@section('title', 'Edit Admin')

@section('content')
    {{-- Menampilkan icon di tab --}}
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">

    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <div class="container">
        <div class="mb-4 border-start border-4 border-warning ps-3">
            <h2 class="fw-semibold text-warning mb-1">
                <i class="bi bi-pencil-fill me-2"></i> Edit Admin
            </h2>
            <small class="text-muted">Ubah informasi pengguna.</small>
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
                <form action="{{ route('kelolaPengguna.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi Baru (opsional)</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Biarkan kosong jika tidak ingin mengganti">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <a href="{{ route('kelolaPengguna') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
