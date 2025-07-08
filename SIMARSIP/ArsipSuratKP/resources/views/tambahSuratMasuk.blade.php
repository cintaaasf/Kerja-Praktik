@extends('layouts.master')

@section('title', 'Tambah Surat Masuk')

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
                <div class="mb-4 border-start border-4 border-primary ps-3">
                    <h2 class="fw-semibold text-primary mb-1">
                        <i class="bi bi-inbox-fill me-2"></i> Tambah Surat Masuk
                    </h2>
                    <small class="text-muted">Isi informasi surat masuk secara lengkap di bawah ini.</small>
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
                        <form action="{{ route('suratMasuk.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="pengirim" class="form-label fs-6">
                                        <i class="bi bi-person-lines-fill me-1"></i>Pengirim
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="pengirim"
                                        name="pengirim" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label fs-6">
                                    <i class="bi bi-calendar3 me-1"></i>Tanggal
                                </label>
                                <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal"
                                    required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label for="nomor" class="form-label fs-6">
                                        <i class="bi bi-hash me-1"></i>Nomor (Surat)
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="nomor" name="nomor"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="perihal" class="form-label fs-6">
                                        <i class="bi bi-chat-left-text me-1"></i>Perihal
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="perihal" name="perihal"
                                        required>
                                </div>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="ditujukan_kepada" class="form-label fs-6">
                                    <i class="bi bi-bookmark-check me-1"></i>Ditujukan Kepada
                                </label>
                                <input type="text" class="form-control form-control-sm" id="ditujukan_kepada"
                                    name="ditujukan_kepada">
                            </div> --}}
                            <div class="mb-3">
                                <label for="ditujukan_kepada" class="form-label fs-6">
                                    <i class="bi bi-person-gear me-1"></i>Ditujukan Kepada
                                </label>
                                <select class="form-select form-select-sm" id="ditujukan_kepada" name="ditujukan_kepada"
                                    required>
                                    <option value="" selected disabled>-- Pilih Pejabat Penanggung Jawab --</option>
                                    <optgroup label="Kasubbag">
                                        <option value="Kasubbag Umum dan Kepegawaian">Kasubbag Umum dan Kepegawaian</option>
                                        <option value="Kasubbag Perencanaan dan Keuangan">Kasubbag Perencanaan dan Keuangan
                                        </option>
                                    </optgroup>
                                    <optgroup label="Kasi">
                                        <option value="Kasi Pemerintahan">Kasi Pemerintahan</option>
                                        <option value="Kasi Trantib">Kasi Trantib</option>
                                        <option value="Kasi PMK">Kasi PMK</option>
                                        <option value="Kasi Kesejahteraan Sosial">Kasi Kesejahteraan Sosial</option>
                                        <option value="Kasi Pelayanan Umum">Kasi Pelayanan Umum</option>
                                    </optgroup>
                                    <optgroup label="Default">
                                        <option value="Belum Ditentukan">Belum Ditentukan</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="file_surat" class="form-label fs-6">
                                    <i class="bi bi-file-earmark-arrow-up me-1"></i>Upload File (PDF)
                                </label>
                                <input type="file" class="form-control form-control-sm" id="file_surat"
                                    name="file_surat" accept=".pdf,.doc,.docx">
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('suratMasuk') }}" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
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
