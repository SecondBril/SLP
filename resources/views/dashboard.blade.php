@extends('layouts.app')

@section('title', 'Dashboard - Rental Mobil')

@section('content')
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1" style="font-weight: 700; font-size: 28px; color: #2d3142;">Dashboard</h1>
            <p class="text-muted mb-0" style="font-size: 14px;">Selamat datang kembali!</p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-light text-dark px-3 py-2" style="font-size: 13px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 5px;">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Peminjam Card -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="stats-card stats-card-primary">
                <div class="stats-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="stats-content">
                    <p class="stats-label">Total Peminjam</p>
                    <h2 class="stats-value">{{ $totalPeminjam }}</h2>
                    <div class="stats-badge">
                        <span class="badge badge-success">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="18 15 12 9 6 15"></polyline>
                            </svg>
                            Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peminjam per Kota Card -->
        <div class="col-12 col-lg-8">
            <div class="stats-card stats-card-secondary">
                <div class="d-flex align-items-center mb-3">
                    <div class="stats-icon-small">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h5 class="mb-0 ms-2" style="font-weight: 600; color: #2d3142;">Peminjam per Kota</h5>
                </div>

                <div class="city-stats">
                    @forelse ($peminjamPerKota as $kota => $jumlah)
                        <div class="city-item">
                            <div class="city-info">
                                <span class="city-dot"></span>
                                <span class="city-name">{{ $kota }}</span>
                            </div>
                            <div class="city-count">
                                <span class="count-badge">{{ $jumlah }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity: 0.3;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <p class="mt-2 mb-0">Belum ada data</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Table -->
    <div class="card-modern">
        <div class="card-modern-header">
            <div>
                <h5 class="mb-1" style="font-weight: 600; color: #2d3142;">Peminjam Terbaru</h5>
                <p class="text-muted mb-0" style="font-size: 13px;">5 pendaftaran terakhir</p>
            </div>
            <a href="{{ route('peminjam.index') }}" class="btn btn-sm btn-outline-primary">
                Lihat Semua
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left: 4px;">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>

        <div class="table-modern-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>
                            <div class="th-content">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Nama Peminjam
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Kota
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                Tanggal Register
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamTerakhir as $index => $peminjam)
                        <tr style="animation-delay: {{ $index * 0.05 }}s;">
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ substr($peminjam['nama_peminjam'], 0, 1) }}</div>
                                    <span class="user-name">{{ $peminjam['nama_peminjam'] }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="location-badge">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    {{ $peminjam['kota'] }}
                                </span>
                            </td>
                            <td>
                                <span class="date-text">{{ \Carbon\Carbon::parse($peminjam['tanggal_register'])->format('d M Y, H:i') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                    <h6 class="mt-3 mb-1">Belum Ada Data</h6>
                                    <p class="text-muted mb-0">Belum ada peminjam yang terdaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            border: 1px solid #f1f2f6;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 0.1;
            transition: all 0.3s ease;
        }

        .stats-card-primary::before {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            transform: translate(50%, -50%);
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .stats-card:hover::before {
            transform: translate(50%, -50%) scale(1.2);
        }

        .stats-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .stats-icon svg {
            width: 28px;
            height: 28px;
            color: white;
        }

        .stats-content {
            position: relative;
            z-index: 1;
        }

        .stats-label {
            font-size: 13px;
            font-weight: 500;
            color: #6c757d;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-value {
            font-size: 36px;
            font-weight: 700;
            color: #2d3142;
            margin-bottom: 12px;
            line-height: 1;
        }

        .stats-badge .badge-success {
            background-color: #d4edda;
            color: #155724;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* City Stats */
        .stats-card-secondary {
            background: white;
        }

        .stats-icon-small {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .stats-icon-small svg {
            width: 20px;
            height: 20px;
            color: white;
        }

        .city-stats {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .city-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #f8f9fa;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .city-item:hover {
            background: #e9ecef;
            transform: translateX(4px);
        }

        .city-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .city-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .city-name {
            font-weight: 500;
            color: #2d3142;
            font-size: 14px;
        }

        .count-badge {
            background: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 700;
            color: #667eea;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Modern Card */
        .card-modern {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f2f6;
            overflow: hidden;
        }

        .card-modern-header {
            padding: 24px;
            border-bottom: 1px solid #f1f2f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        /* Modern Table */
        .table-modern-container {
            overflow-x: auto;
        }

        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern thead th {
            background-color: #f8f9fa;
            padding: 16px 24px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
        }

        .th-content {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .th-content svg {
            opacity: 0.6;
        }

        .table-modern tbody tr {
            transition: all 0.2s ease;
            animation: fadeInUp 0.4s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-modern tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table-modern tbody td {
            padding: 18px 24px;
            border-bottom: 1px solid #f1f2f6;
            color: #2d3142;
            font-size: 14px;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 15px;
            text-transform: uppercase;
        }

        .user-name {
            font-weight: 500;
            color: #2d3142;
        }

        .location-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: #e3f2fd;
            color: #1976d2;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .date-text {
            color: #6c757d;
            font-size: 13px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state svg {
            color: #dee2e6;
            margin-bottom: 16px;
        }

        .empty-state h6 {
            font-weight: 600;
            color: #6c757d;
        }

        /* Buttons */
        .btn-outline-primary {
            border-color: #ff6b35;
            color: #ff6b35;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn-outline-primary:hover {
            background-color: #ff6b35;
            border-color: #ff6b35;
            color: white;
            transform: translateX(4px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-card {
                padding: 20px;
            }

            .stats-value {
                font-size: 28px;
            }

            .card-modern-header {
                padding: 20px;
            }

            .table-modern thead th,
            .table-modern tbody td {
                padding: 14px 16px;
                font-size: 13px;
            }

            .user-avatar {
                width: 34px;
                height: 34px;
                font-size: 13px;
            }

            .city-item {
                padding: 10px 14px;
            }
        }

        @media (max-width: 576px) {
            .table-modern thead th,
            .table-modern tbody td {
                padding: 12px;
            }

            .location-badge {
                font-size: 12px;
                padding: 5px 10px;
            }
        }
    </style>
@endsection
