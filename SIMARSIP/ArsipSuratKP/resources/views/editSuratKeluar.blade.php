@extends('layouts.master')

@section('title', 'Edit Surat Keluar')

@section('content')
    {{-- Menampilkan icon di tab --}}
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">

    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    {{-- Css --}}
    <link rel="stylesheet" href="{{ asset('css/editSurat.css') }}">

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                {{-- Judul --}}
                <div class="mb-4 border-start border-4 border-success ps-3">
                    <h2 class="fw-semibold text-success mb-1">
                        <i class="bi bi-send-check-fill me-2"></i> Edit Surat Keluar
                    </h2>
                    <small class="text-muted">Perbarui data surat keluar di bawah ini.</small>
                </div>

                {{-- Error & Success --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Munculkan keterangan --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Form --}}
                <div class="card shadow rounded-3 border-0">
                    <div class="card-body p-4 bg-light">
                        <form action="{{ route('suratKeluar.update', $surat->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nomor_berkas" class="form-label">Nomor Berkas</label>
                                    <input type="text" class="form-control form-control-sm" id="nomor_berkas"
                                        name="nomor_berkas" value="{{ old('nomor_berkas', $surat->nomor_berkas) }}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="penerima" class="form-label">Penerima</label>
                                    <input type="text" class="form-control form-control-sm" id="penerima"
                                        name="penerima" value="{{ old('penerima', $surat->penerima) }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Surat</label>
                                <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal"
                                    value="{{ old('tanggal', $surat->tanggal) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="perihal" class="form-label">Perihal</label>
                                <input type="text" class="form-control form-control-sm" id="perihal" name="perihal"
                                    value="{{ old('perihal', $surat->perihal) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                <input type="text" class="form-control form-control-sm" id="nomor_surat"
                                    name="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
                                <input type="date" class="form-control form-control-sm" id="tanggal_terima"
                                    name="tanggal_terima" value="{{ old('tanggal_terima', $surat->tanggal_terima) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="file_surat" class="form-label">Upload File Surat (PDF)</label>
                                @if ($surat->file_surat)
                                    <p class="mb-1">File saat ini:
                                        <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank">Lihat
                                            File</a>
                                    </p>
                                @endif
                                <input type="file" class="form-control form-control-sm" id="file_surat" name="file_surat"
                                    accept=".pdf,.doc,.docx">
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('suratKeluar') }}" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-left"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save2 me-1"></i> Simpan Perubahan
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
        const tanggalTerimaInput = document.getElementById('tanggal_terima');
        tanggalInput.addEventListener('focus', function() {
            this.showPicker?.(); // Chrome dan Edge mendukung showPicker()
        });
        tanggalInput.addEventListener('focus', function() {
            this.showPicker?.(); // Chrome dan Edge mendukung showPicker()
        });
    });
</script>
