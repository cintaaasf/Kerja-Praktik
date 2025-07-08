@extends('layouts.master')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- Menampilkan icon di tab --}}
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">

    @php
        use Carbon\Carbon;
        $bulanTampil = request('filter_bulan')
            ? Carbon::createFromFormat('Y-m', request('filter_bulan'))->translatedFormat('F Y')
            : now()->translatedFormat('F Y');
        $currentMonth = now()->format('Y-m');
    @endphp

    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    {{-- Css --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">


    <div class="container-fluid">
        <h4 class="mb-4 text-dark">👋 Selamat Datang, <strong>{{ Auth::user()->name }}</strong></h4>

        {{-- Statistik Card --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <a href="{{ route('suratMasuk') }}" class="text-decoration-none">
                    <div class="card card-hover shadow-sm h-100 py-3 bg-soft-blue border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-uppercase text-muted small">Total Surat Masuk</div>
                                <h4 class="text-primary fw-bold">{{ $jumlahSuratMasuk }}</h4>
                            </div>
                            <i class="bi bi-inbox-fill fs-1 text-primary"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('suratKeluar') }}" class="text-decoration-none">
                    <div class="card card-hover shadow-sm h-100 py-3 bg-soft-green border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-uppercase text-muted small">Total Surat Keluar</div>
                                <h4 class="text-success fw-bold">{{ $jumlahSuratKeluar }}</h4>
                            </div>
                            <i class="bi bi-send-fill fs-1 text-success"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card card-hover shadow-sm h-100 py-3 bg-soft-gray border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-uppercase text-muted small">Total Seluruh Surat</div>
                            <h4 class="text-dark fw-bold">{{ $totalSurat }}</h4>
                        </div>
                        <i class="bi bi-archive-fill fs-1 text-dark"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Bulan --}}
        <form action="{{ route('dashboard') }}" method="GET" class="d-flex gap-2 align-items-center mb-3 flex-wrap">
            <input type="month" name="filter_bulan" class="form-control form-control-sm shadow-sm"
                value="{{ request('filter_bulan', $currentMonth) }}" style="max-width: 200px;">
            <button type="submit" class="btn btn-sm btn-secondary shadow-sm">
                <i class="bi bi-funnel-fill"></i> Filter Bulan
            </button>
        </form>

        {{-- Data Bulan Ini --}}
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 mb-3 bg-light">
                    <div class="card-body">
                        <h6 class="text-dark">Surat Masuk Bulan {{ $bulanTampil }}</h6>
                        <h4 class="text-primary fw-semibold">{{ $suratMasukBulanIni }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 mb-3 bg-light">
                    <div class="card-body">
                        <h6 class="text-dark">Surat Keluar Bulan {{ $bulanTampil }}</h6>
                        <h4 class="text-success fw-semibold">{{ $suratKeluarBulanIni }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Surat Terbaru --}}
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-dark fw-bold">🕘 Surat Masuk Terbaru</h6>
                    <a href="{{ route('suratMasuk') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <ul class="list-group shadow-sm">
                    @forelse ($suratMasukTerbaru as $surat)
                        <li class="list-group-item">
                            <i class="bi bi-inbox-fill text-primary me-2"></i>
                            {{ $surat->nomor }} - {{ $surat->perihal }}
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada surat masuk</li>
                    @endforelse
                </ul>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-dark fw-bold">🕘 Surat Keluar Terbaru</h6>
                    <a href="{{ route('suratKeluar') }}" class="btn btn-sm btn-outline-success">Lihat Semua</a>
                </div>
                <ul class="list-group shadow-sm">
                    @forelse ($suratKeluarTerbaru as $surat)
                        <li class="list-group-item">
                            <i class="bi bi-send-fill text-success me-2"></i>
                            {{ $surat->nomor_surat }} - {{ $surat->perihal }}
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada surat keluar</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
