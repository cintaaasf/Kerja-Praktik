@extends('layouts.master')

@section('title', 'Surat Masuk')

@section('content')
    {{-- Menampilkan icon di tab --}}
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">

    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    {{-- Css --}}
    <link rel="stylesheet" href="{{ asset('css/suratMasuk.css') }}">

    <div class="container-fluid">
        {{-- Judul Halaman --}}
        <div class="mb-4 border-start border-4 border-primary ps-3">
            <h2 class="fw-semibold text-primary mb-1">
                <i class="bi bi-inbox-fill me-2"></i> Arsip Surat Masuk
            </h2>
            <small class="text-muted">Daftar semua surat masuk yang sudah diarsipkan.</small>
        </div>

        {{-- Filter & Tambah --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            {{-- Form Pencarian --}}
            <form id="searchForm" action="{{ route('suratMasuk') }}" method="GET"
                class="d-flex align-items-center flex-wrap gap-2">
                <div class="input-group input-group-sm shadow-sm" style="max-width: 280px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" name="search" class="form-control border-start-0"
                        placeholder="Cari berkas/pengirim/perihal/ditujukan kepada" value="{{ request('search') }}">
                </div>

                {{-- filter tanggal --}}
                <input type="date" name="tanggal" class="form-control form-control-sm shadow-sm"
                    value="{{ request('tanggal') }}" style="max-width: 200px;">

                <button type="submit" class="btn btn-sm btn-outline-secondary shadow-sm">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
            </form>

            {{-- Tombol Tambah --}}
            <a href="{{ route('suratMasuk.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Surat
            </a>
        </div>

        {{-- Tabel Data --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th>No</th>
                            <th>Nomor Berkas</th>
                            <th>Pengirim</th>
                            <th>Tanggal</th>
                            <th>Nomor Surat</th>
                            <th>Perihal</th>
                            <th>Ditujukan Kepada</th>
                            <th>File Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($suratMasuk as $index => $surat)
                            <tr>
                                <td class="text-center">{{ $suratMasuk->firstItem() + $index }}</td>
                                <td>{{ $surat->nomor_berkas }}</td>
                                <td>{{ $surat->pengirim }}</td>
                                <td>{{ \Carbon\Carbon::parse($surat->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $surat->nomor }}</td>
                                <td class="wrap-column">{{ $surat->perihal }}</td>
                                <td class="text-center wrap-column">{{ $surat->ditujukan_kepada ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($surat->file_surat)
                                        <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-earmark-text"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak Ada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('suratMasuk.edit', $surat->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox-fill fs-4 text-secondary"></i><br>
                                    Belum ada surat masuk yang diarsipkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Menampilkan next halaman --}}
                <div class="p-3">
                    {{ $suratMasuk->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
@endsection

{{-- js untuk pencarian berdasarkaan inputan user --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');

        let timer = null;

        if (searchInput && searchForm) {
            searchInput.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    searchForm.submit();
                }, 500); // submit 0.5 detik setelah user berhenti mengetik
            });
        }
    });
</script>
