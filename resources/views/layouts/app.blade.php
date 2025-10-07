<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rental Mobil')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
            font-size: 14px;
        }

        /* Mobile Header */
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background-color: #ffffff;
            border-bottom: 1px solid #e8e9ed;
            z-index: 1000;
            padding: 0 20px;
            align-items: center;
            justify-content: space-between;
        }

        .logo-mobile {
            height: 40px;
            width: 40px;
            object-fit: cover;
        }

        .mobile-header .brand-mobile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mobile-header .brand-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
        }

        .mobile-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #2d3142;
        }

        .hamburger {
            width: 30px;
            height: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
        }

        .hamburger span {
            width: 100%;
            height: 3px;
            background-color: #2d3142;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            padding: 25px 20px;
            background-color: #ffffff;
            border-right: 1px solid #e8e9ed;
            overflow-y: auto;
            z-index: 1001;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .sidebar-brand .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
        }

        .sidebar-brand h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #2d3142;
        }

        .sidebar-menu {
            margin-bottom: 30px;
        }

        .sidebar-menu-title {
            font-size: 11px;
            font-weight: 600;
            color: #a0a4b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            padding-left: 10px;
        }

        .sidebar .nav-link {
            color: #6c757d;
            font-weight: 500;
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
            color: #ff6b35;
        }

        .sidebar .nav-link.active {
            background-color: #ff6b35;
            color: #ffffff;
            font-weight: 600;
        }

        .sidebar .nav-link .badge {
            margin-left: auto;
            font-size: 11px;
            font-weight: 600;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px); /* Tambahan untuk kalkulasi lebar */
        }

        .content-wrapper {
             padding: 30px;
             min-height: 100vh;
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .table {
            font-size: 14px;
        }

        .table thead th {
            font-weight: 600;
            color: #6c757d;
            border-bottom: 2px solid #e8e9ed;
            padding: 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f2f6;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Tablet Styles */
        @media (max-width: 991px) {
            .sidebar {
                width: 240px;
            }

            .main-content {
                margin-left: 240px;
                width: calc(100% - 240px);
            }
            .content-wrapper {
                padding: 25px;
            }
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .mobile-header {
                display: flex;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-brand {
                margin-bottom: 30px;
            }

            .main-content {
                margin-left: 0;
                margin-top: 60px;
                width: 100%; /* Lebar penuh di mobile */
            }

            .content-wrapper {
                 padding: 20px 15px;
            }

            .card-custom {
                border-radius: 10px;
            }

            .table {
                font-size: 13px;
            }

            .table thead th {
                padding: 12px 10px;
                font-size: 12px;
            }

            .table tbody td {
                padding: 12px 10px;
            }

            /* == [ PERBAIKAN UTAMA DI SINI ] == */
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto; /* Mengaktifkan scroll horizontal */
                -webkit-overflow-scrolling: touch; /* Scroll lebih mulus di iOS */
                border-radius: 10px;
            }

            /* Mencegah teks turun ke bawah di dalam tabel yang responsif */
            .table-responsive table th,
            .table-responsive table td {
                white-space: nowrap;
            }
        }
        /* Small Mobile Styles */
        @media (max-width: 576px) {
            .mobile-header {
                padding: 0 15px;
            }

            .mobile-header h4 {
                font-size: 14px;
            }

            .main-content {
                padding: 15px 10px;
            }

            .sidebar {
                width: 280px;
                max-width: 85%;
            }

            .table {
                font-size: 12px;
            }

            .table thead th {
                padding: 10px 8px;
                font-size: 11px;
            }

            .table tbody td {
                padding: 10px 8px;
            }

            .btn {
                font-size: 13px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header">
        <div class="brand-mobile">
            <img src="logo.png" alt="Logo Rental Mobil" class="logo-mobile rounded-2">
        </div>
        <button class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="d-flex">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <img src="logo.png" alt="Logo Rental Mobil" class="logo-mobile rounded-2">
                <h4>Rental Mobil</h4>
            </div>

            <div class="sidebar-menu">
                <div class="sidebar-menu-title">Menu</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('peminjam.*') ? 'active' : '' }}" href="{{ route('peminjam.index') }}">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Data Peminjam
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="main-content flex-grow-1 content-wrapper">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hamburger Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            hamburger.classList.toggle('active');
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        }

        hamburger.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking a link on mobile
        const sidebarLinks = sidebar.querySelectorAll('.nav-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                hamburger.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
