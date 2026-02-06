<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'App Pegawai')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 90px;
            --header-height: 65px;
            --primary-gradient: linear-gradient(135deg, #6176ee 0%, #5165d6 100%);
            --primary-color: #6176ee;
            --accent-yellow: #f0cb50;
            --sidebar-border: #e0e0e0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins';
        }

        body {
            background-color: #f4f6ff;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            height: calc(100vh - var(--header-height));
            width: var(--sidebar-width);
            background: #ffffff;
            transition: width 0.3s ease, transform 0.3s ease;
            z-index: 1030;
            overflow-y: auto;
            border-right: 1px solid var(--sidebar-border);
            box-shadow: 2px 0 5px rgba(183, 85, 85, 0.05);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #f0f1f5;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: var(--accent-yellow);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #fff;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .logo-text h2 {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .logo-text .subtitle {
            font-size: 12px;
            color: #6b7280;
        }

        /* Search Box */

        /* Navigation Menu */
        .nav-menu {
            padding: 18px 15px 80px;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #555;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.15s ease, color 0.15s ease;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 6px;
            position: relative;
            padding-right: 48px;
            /* space for pill-close */
        }

        .nav-link-item:hover {
            background: #6176ee;
            color: #ffffff;
            box-shadow: 0 4px 8px rgba(97, 118, 238, 0.12);
            border-radius: 999px;
        }

        .nav-link-item.active {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 8px rgba(97, 118, 238, 0.12);
            border-radius: 999px;
        }

        .sidebar.collapsed .nav-link-item {
            padding-right: 12px;
        }

        .nav-link-item i {
            width: 20px;
            font-size: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-link-item .text {
            flex: 1;
            transition: opacity 0.3s;
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-link-item .text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-link-item {
            justify-content: center;
            padding: 12px;
        }

        /* Bottom Menu */
        .nav-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            width: var(--sidebar-width);
            padding: 12px;
            border-top: 1px solid #f0f1f5;
            background: white;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed~.nav-bottom {
            width: var(--sidebar-collapsed-width);
        }

        .form-switch {
            padding-left: 0;
        }

        .form-check-input {
            width: 44px;
            height: 24px;
            cursor: pointer;
            background-color: #e5e7eb;
            border: none;
            background-image: none;
        }

        .form-check-input:checked {
            background-color: #6366f1;
        }

        .form-check-input:focus {
            box-shadow: none;
            border: none;
        }

        /* Header */
        .header {
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            height: var(--header-height);
            background: var(--primary-color);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            z-index: 1050;
            color: #fff;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .toggle-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: var(--primary-color);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s ease, transform 0.12s ease;
            color: #fff;
        }

        .toggle-btn:hover {
            background: #5165d6;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #fff;
            margin: 0;
        }

        .header-welcome {
            font-size: 18px;
            font-weight: 600;
            color: #fff;
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 30px;
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - var(--header-height));
            position: relative;
        }

        .sidebar.collapsed~.header~.main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Footer */

        .sidebar.collapsed~.footer {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
                transform: translateX(-100%);
                /* Kita kembalikan ke -100% untuk menyembunyikan di mobile agar tidak mengganggu */
            }

            /* Jika sidebar tersembunyi di mobile, main-content harus kembali ke kiri */
            .sidebar.collapsed {
                transform: translateX(0);
            }

            .main-content,
            .footer {
                /* Atur margin ke 0 agar main-content menggunakan lebar penuh di mobile */
                margin-left: 0 !important;
            }

            .nav-bottom {
                width: var(--sidebar-collapsed-width);
                left: 0 !important;
            }
        }

        /* --- CSS KOREKSI MASALAH UTAMA (REVISI) --- */
        /* Menyembunyikan elemen apapun yang muncul di luar konteks utama content. 
           Kita gunakan selector yang lebih spesifik jika elemen tersebut adalah pseudo-element. */

        /* KOREKSI POTENSIAL 1: Ikon Bootstrap yang Membesar */
        /* Jika ada ikon panah yang membesar, batasi ukurannya di luar elemen sidebar */
        i.bi-chevron-left {
            font-size: 1rem !important;
            position: initial !important;
        }

        /* KOREKSI POTENSIAL 2: Teks/Entitas yang Membesar di Body */
        /* Jika itu adalah karakter `<` biasa yang membesar */
        body>* {
            font-size: initial;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">AP</div>
            <div class="logo-text">
                <h2>APP PEGAWAI</h2>
                <div class="subtitle">Aplikasi Pegawai</div>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="{{ route('employees.index') }}"
                class="{{ request()->routeIs('employees.*') ? 'nav-link-item active' : 'nav-link-item' }}">
                <i class="bi bi-people"></i>
                <span class="text">Employees</span>
            </a>
            <a href="{{ route('departments.index') }}"
                class="{{ request()->routeIs('departments.*') ? 'nav-link-item active' : 'nav-link-item' }}">
                <i class="bi bi-building"></i>
                <span class="text">Departments</span>
            </a>
            <a href="{{ route('positions.index') }}"
                class="{{ request()->routeIs('positions.*') ? 'nav-link-item active' : 'nav-link-item' }}">
                <i class="bi bi-briefcase"></i>
                <span class="text">Positions</span>
            </a>
            <a href="{{ route('attendance.index') }}"
                class="{{ request()->routeIs('attendance.*') ? 'nav-link-item active' : 'nav-link-item' }}">
                <i class="bi bi-calendar-check"></i>
                <span class="text">Attendance</span>
            </a>
            <a href="{{ route('salaries.index') }}"
                class="{{ request()->routeIs('salaries.*') ? 'nav-link-item active' : 'nav-link-item' }}">
                <i class="bi bi-currency-dollar"></i>
                <span class="text">Reports</span>
            </a>
            <a href="{{ route('performance-reviews.index') }}"
                class="{{ request()->routeIs('performance-reviews.*') ? 'nav-link-item active' : 'nav-link-item'}}">
                <i class="bi bi-graph-up"></i>
                <span class="text">Performance</span>
            </a>
        </nav>

        <!-- Karena .nav-bottom tidak ada di sini, saya asumsikan itu diletakkan di footer/bawah -->
    </aside>

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div class="header-welcome">WELCOME MY APP</div>
        </div>
    </header>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')

        <!-- Demo Content -->

    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');

            // Toggle collapsed class
            sidebar.classList.toggle('collapsed');

            // Atur margin-left content berdasarkan status sidebar
            const sidebarWidth = sidebar.classList.contains('collapsed')
                ? getComputedStyle(document.documentElement).getPropertyValue('--sidebar-collapsed-width').trim()
                : getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width').trim();

            // Hanya atur margin jika tampilan desktop
            if (window.innerWidth > 768) {
                mainContent.style.marginLeft = sidebarWidth;
            }
        }

        // --- LOGIKA UTAMA UNTUK MENGATASI TAMPILAN GAGAL PADA LAYAR BESAR ---
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');

            // Set margin awal saat dimuat (hanya jika desktop)
            if (window.innerWidth > 768) {
                if (!sidebar.classList.contains('collapsed')) {
                    mainContent.style.marginLeft = getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width');
                }
            } else {
                // Di mobile, pastikan margin 0
                mainContent.style.marginLeft = '0';
            }
        });

        // ---- ACTIVE LINK HANDLING ----
        document.querySelectorAll('.nav-link-item').forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');

                // Jika ini bukan link navigasi yang sebenarnya (placeholder), cegah default
                if (href === '#' || href.startsWith('#')) {
                    e.preventDefault();
                    document.querySelectorAll('.nav-link-item').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                }

                // MOBILE: Tutup sidebar di mobile setelah klik (baik itu placeholder atau navigasi sungguhan)
                if (window.innerWidth <= 768) {
                    document.getElementById('sidebar').classList.add('collapsed');
                }
            });
        });

        // 🟢 KODE NOTIFIKASI SUKSES (SUDAH DIKOREKSI) 🟢
        @if (session('success'))

            // Tidak perlu tag <script> di dalam sini

            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                html: '{!! session('success') !!}',
                showConfirmButton: false,
                timer: 3000

            });

        @endif

        function confirmDelete(event, formId) {
            // Mencegah pengiriman form secara default
            event.preventDefault();
            Swal.fire({
                title: "Yakin Hapus Data?", // Teks Judul (seperti pada Gambar 1)
                text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                icon: "warning", // Menampilkan ikon peringatan
                showCancelButton: true,
                confirmButtonColor: "#d33", // Warna merah untuk tombol Ya
                cancelButtonColor: "#3085d6", // Warna biru untuk tombol Batal
                confirmButtonText: "Ya, Hapus!", // Teks tombol Ya
                cancelButtonText: "Batal" // Teks tombol Batal

            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user mengklik 'Ya, Hapus!', submit form yang sebenarnya
                    document.getElementById('delete-form-' + formId).submit();

                }

            });

        }

    </script>
</body>
</html>