@extends('layouts.master')

@section('title', 'Tambah Surat Keluar')

@section('content')
    {{-- Menampilkan icon di tab --}}
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">

    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    {{-- Css --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                {{-- Judul Halaman --}}
                <div class="mb-4 border-start border-4 border-success ps-3">
                    <h2 class="fw-semibold text-success mb-1">
                        <i class="bi bi-send-plus-fill me-2"></i> Tambah Surat Keluar
                    </h2>
                    <small class="text-muted">Isi informasi surat keluar dengan lengkap sebelum mengirim.</small>
                </div>

                {{-- Notifikasi --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Form --}}
                <div class="card shadow rounded-3 border-0">
                    <div class="card-body p-4 bg-light">
                        <form action="{{ route('suratKeluar.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label for="nomor_berkas" class="form-label fs-6">
                                        <i class="bi bi-archive me-1"></i>Nomor Berkas
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="nomor_berkas"
                                        name="nomor_berkas" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="penerima" class="form-label fs-6">
                                        <i class="bi bi-person-lines-fill me-1"></i>Penerima
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="penerima"
                                        name="penerima" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label fs-6">
                                    <i class="bi bi-calendar3 me-1"></i>Tanggal
                                </label>
                                <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="perihal" class="form-label fs-6">
                                    <i class="bi bi-chat-left-text me-1"></i>Perihal
                                </label>
                                <input type="text" class="form-control form-control-sm" id="perihal" name="perihal"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_surat" class="form-label fs-6">
                                    <i class="bi bi-hash me-1"></i>Nomor Surat
                                </label>
                                <input type="text" class="form-control form-control-sm" id="nomor_surat"
                                    name="nomor_surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="file_surat" class="form-label fs-6">
                                    <i class="bi bi-file-earmark-arrow-up me-1"></i>Upload File (PDF)
                                </label>
                                <input type="file" class="form-control form-control-sm" id="file_surat" name="file_surat"
                                    accept=".pdf,.doc,.docx">
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="/dashboard" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save2 me-1"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- js untuk kursor ke field tanggal/pemilihan filter tanggal --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tanggalInput = document.getElementById('tanggal');

        tanggalInput.addEventListener('focus', function() {
            this.showPicker?.(); // Chrome dan Edge mendukung showPicker()
        });
    });
</script>
