<!DOCTYPE html>
@php
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
@endphp

<html lang="id">

<head>
    {{-- Menampilkan icon di tab --}}
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">

    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Css --}}
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- Google Fonts: Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

{{-- Tampilan sidebar --}}

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar">
            <a href="/dashboard" class="d-block text-center text-decoration-none text-white py-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo E-Arsip" style="max-width: 50px;" class="mb-1">
                <div style="font-weight: 600; font-size: 20px;">SIMARSIP</div>
            </a>
            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>
            <a href="{{ route('suratMasuk.create') }}" class="{{ request()->is('suratMasuk/create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i>Tambah Surat Masuk
            </a>
            <a href="{{ route('suratKeluar.create') }}"
                class="{{ request()->is('suratKeluar/create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i>Tambah Surat Keluar
            </a>
            <a data-bs-toggle="collapse" href="#arsipMenu" role="button"
                aria-expanded="{{ request()->is('suratMasuk') || request()->is('suratKeluar') ? 'true' : 'false' }}"
                aria-controls="arsipMenu" class="d-flex align-items-center">
                <i class="bi bi-folder2-open me-2"></i> Arsip Surat
                <i class="bi ms-auto {{ request()->is('suratMasuk') || request()->is('suratKeluar') ? 'bi-chevron-up' : 'bi-chevron-down' }}"
                    id="arsipIcon"></i>
            </a>
            <div class="collapse ps-3 {{ request()->is('suratMasuk') || request()->is('suratKeluar') ? 'show' : '' }}"
                id="arsipMenu">
                <a href="{{ route('suratMasuk') }}"
                    class="d-block py-1 {{ request()->is('suratMasuk') ? 'active' : '' }}">
                    <i class="bi bi-inbox"></i> Surat Masuk
                </a>
                <a href="{{ route('suratKeluar') }}"
                    class="d-block py-1 {{ request()->is('suratKeluar') ? 'active' : '' }}">
                    <i class="bi bi-send"></i> Surat Keluar
                </a>
            </div>
            <a href="/logout" class="text-white mt-4 d-block text-center bg-danger px-3 mx-4 rounded">

                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
        <!-- Main Content -->
        <div class="content">
            <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>

</body>

</html>
