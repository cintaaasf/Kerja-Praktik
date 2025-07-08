@extends('layouts.master')

@section('title', 'Edit Surat Masuk')

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
                <div class="mb-4 border-start border-4 border-primary ps-3">
                    <h2 class="fw-semibold text-primary mb-1">
                        <i class="bi bi-pencil-square me-2"></i> Edit Surat Masuk
                    </h2>
                    <small class="text-muted">Perbarui data surat masuk di bawah ini.</small>
                </div>

                {{-- Error dan Success --}}
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
                        <form action="{{ route('suratMasuk.update', $surat->id) }}" method="POST"
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
                                    <label for="pengirim" class="form-label">Pengirim</label>
                                    <input type="text" class="form-control form-control-sm" id="pengirim"
                                        name="pengirim" value="{{ old('pengirim', $surat->pengirim) }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal"
                                        value="{{ old('tanggal', $surat->tanggal) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nomor" class="form-label">Nomor Surat</label>
                                    <input type="text" class="form-control form-control-sm" id="nomor" name="nomor"
                                        value="{{ old('nomor', $surat->nomor) }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="perihal" class="form-label">Perihal</label>
                                    <input type="text" class="form-control form-control-sm" id="perihal" name="perihal"
                                        value="{{ old('perihal', $surat->perihal) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="ditujukan_kepada" class="form-label">
                                        <i class="bi bi-person-gear me-1"></i>Ditujukan Kepada
                                    </label>
                                    <select class="form-select form-select-sm" id="ditujukan_kepada" name="ditujukan_kepada"
                                        required>
                                        <option value="" disabled
                                            {{ old('ditujukan_kepada', $surat->ditujukan_kepada) == '' ? 'selected' : '' }}>
                                            -- Pilih Pejabat Penanggung Jawab --
                                        </option>
                                        <optgroup label="Kasubbag">
                                            <option value="Kasubbag Umum dan Kepegawaian"
                                                {{ old('ditujukan_kepada', $surat->ditujukan_kepada) == 'Kasubbag Umum dan Kepegawaian' ? 'selected' : '' }}>
                                                Kasubbag Umum dan Kepegawaian
                                            </option>
                                            <option value="Kasubbag Perencanaan dan Keuangan"
                                                {{ old('ditujukan_kepada', $surat->ditujukan_kepada) == 'Kasubbag Perencanaan dan Keuangan' ? 'selected' : '' }}>
                                                Kasubbag Perencanaan dan Keuangan
                                            </option>
                                        </optgroup>
                                        <optgroup label="Kasi">
                                            <option value="Kasi Pemerintahan"
                                                {{ old('ditujukan_kepada', $surat->ditujukan_kepada) == 'Kasi Pemerintahan' ? 'selected' : '' }}>
                                                Kasi Pemerintahan
                                            </option>
                                            <option value="Kasi Trantib"
                                                {{ old('ditujukan_kepada', $surat->ditujukan_kepada) == 'Kasi Trantib' ? 'selected' : '' }}>
                                                Kasi Trantib
                                            </option>
                                            <option value="Kasi PMK"
                                                {{ old('ditujukan_kepada', $surat->ditujukan_kepada) == 'Kasi PMK' ? 'selected' : '' }}>
                                                Kasi PMK
                                            </option>
                                            <option value="Kasi Kesejahteraan Sosial"
                                                {{ old('ditujukan_kepada', $surat->ditujukan_kepada) == 'Kasi Kesejahteraan Sosial' ? 'selected' : '' }}>
                                                Kasi Kesejahteraan Sosial
                                            </option>
                                            <option value="Kasi Pelayanan Umum"
                                                {{ old('ditujukan_kepada', $surat->ditujukan_kepada) == 'Kasi Pelayanan Umum' ? 'selected' : '' }}>
                                                Kasi Pelayanan Umum
                                            </option>
                                        </optgroup>
                                        <optgroup label="Default">
                                            <option value="Belum Ditentukan"
                                                {{ old('ditujukan_kepada', $surat->ditujukan_kepada) == 'Belum Ditentukan' ? 'selected' : '' }}>
                                                Belum Ditentukan
                                            </option>
                                        </optgroup>
                                    </select>
                                </div>
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
                                <a href="{{ route('suratMasuk') }}" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-left"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
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

        tanggalInput.addEventListener('focus', function() {
            this.showPicker?.(); // Chrome dan Edge mendukung showPicker()
        });
    });
</script>
