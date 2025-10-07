@extends('layouts.app')

@section('title', 'Data Peminjam - Rental Mobil')

@section('content')
    <!-- Header Section -->
    <div class="page-header mb-4">
        <div class="page-header-content">
            <div>
                <h1 class="mb-1" style="font-weight: 700; font-size: 28px; color: #2d3142;">Data Peminjaman</h1>
                <p class="text-muted mb-0" style="font-size: 14px;">Kelola data peminjam rental mobil</p>

            </div>
            <a href="{{ route('peminjam.create') }}" class="btn-add">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Peminjam
            </a>
        </div>
    </div>

    <!-- Success Alert -->
    @if (session('success'))
        <div class="alert-modern alert-modern-success">
            <div class="alert-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="alert-content">
                <p class="alert-title">Berhasil!</p>
                <p class="alert-message">{{ session('success') }}</p>
            </div>
            <button class="alert-close" onclick="this.parentElement.remove()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    @endif

    <!-- Stats Bar -->
    <div class="stats-bar mb-4">
        <div class="stat-item">
            <div class="stat-icon stat-icon-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Peminjam</p>
                <h3 class="stat-value" id="totalCount">{{ count($peminjam) }}</h3>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon stat-icon-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Kota</p>
                <h3 class="stat-value">{{ $peminjam->pluck('kota')->unique()->count() }}</h3>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon stat-icon-info">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Pendaftar Hari Ini</p>
                <h3 class="stat-value">{{ $peminjam->filter(fn($p) => \Carbon\Carbon::parse($p['tanggal_register'])->isToday())->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="data-card">
        <div class="data-card-header">
            <h5 class="data-card-title">Daftar Peminjam</h5>
            <span class="result-count" id="resultCount">Menampilkan {{ count($peminjam) }} data</span>
        </div>

        <div class="table-container">
            <table class="data-table" id="peminjamTable">
                <thead>
                    <tr>
                        <th class="th-number">
                            <div class="th-content">#</div>
                        </th>
                        <th class="th-name">
                            <div class="th-content">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Nama Peminjam
                            </div>
                        </th>
                        <th class="th-nik">
                            <div class="th-content">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                NIK
                            </div>
                        </th>
                        <th class="th-kota">
                            <div class="th-content">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Kota
                            </div>
                        </th>
                        <th class="th-hp">
                            <div class="th-content">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                No. HP
                            </div>
                        </th>
                        <th class="th-date">
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
                <tbody id="tableBody">
                    @forelse ($peminjam as $index => $data)
                        <tr class="table-row" data-search="{{ strtolower($data['nama_peminjam'] . ' ' . $data['nik'] . ' ' . $data['hp']) }}" data-city="{{ $data['kota'] }}">
                            <td class="td-number">
                                <span class="row-number">{{ $index + 1 }}</span>
                            </td>
                            <td class="td-name">
                                <div class="user-info">
                                    <div class="user-avatar">{{ substr($data['nama_peminjam'], 0, 1) }}</div>
                                    <span class="user-name">{{ $data['nama_peminjam'] }}</span>
                                </div>
                            </td>
                            <td class="td-nik">
                                <span class="nik-badge">{{ $data['nik'] }}</span>
                            </td>
                            <td class="td-kota">
                                <span class="location-tag">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    {{ $data['kota'] }}
                                </span>
                            </td>
                            <td class="td-hp">
                                <a href="tel:{{ $data['hp'] }}" class="phone-link">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                    {{ $data['hp'] }}
                                </a>
                            </td>
                            <td class="td-date">
                                <div class="date-info">
                                    <span class="date-text">{{ \Carbon\Carbon::parse($data['tanggal_register'])->format('d M Y') }}</span>
                                    <span class="time-text">{{ \Carbon\Carbon::parse($data['tanggal_register'])->format('H:i') }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <h5 class="empty-title">Belum Ada Data Peminjam</h5>
                                    <p class="empty-text">Mulai tambahkan data peminjam dengan klik tombol "Tambah Peminjam" di atas</p>
                                    <a href="{{ route('peminjam.create') }}" class="btn-add btn-add-small">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Tambah Peminjam
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- No Results State -->
        <div class="no-results" id="noResults" style="display: none;">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <h5 class="no-results-title">Tidak Ada Hasil</h5>
            <p class="no-results-text">Coba ubah kata kunci pencarian atau filter yang dipilih</p>
        </div>
    </div>

    <style>
        /* Page Header */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #2d3142;
            margin-bottom: 4px;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
        }

        /* Add Button */
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 53, 0.4);
            color: white;
        }

        .btn-add-small {
            padding: 10px 20px;
            font-size: 13px;
        }

        /* Alert Modern */
        .alert-modern {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-modern-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid #28a745;
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .alert-icon svg {
            color: #28a745;
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            color: #155724;
            margin-bottom: 2px;
            font-size: 14px;
        }

        .alert-message {
            color: #155724;
            margin: 0;
            font-size: 13px;
        }

        .alert-close {
            background: none;
            border: none;
            cursor: pointer;
            color: #155724;
            opacity: 0.6;
            transition: opacity 0.2s;
            padding: 4px;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* Stats Bar */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .stat-item {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f2f6;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon-primary {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .stat-icon-success {
            background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .stat-icon-info {
            background: linear-gradient(135deg, #17a2b8 0%, #1fc8db 100%);
            box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
        }

        .stat-icon svg {
            color: white;
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #2d3142;
            margin: 0;
        }

        /* Data Card */
        .data-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f2f6;
            overflow: hidden;
        }

        .data-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f2f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .data-card-title {
            font-size: 16px;
            font-weight: 600;
            color: #2d3142;
            margin: 0;
        }

        .result-count {
            font-size: 13px;
            color: #6c757d;
            font-weight: 500;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead th {
            background: #f8f9fa;
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
            white-space: nowrap;
        }

        .th-content {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .th-content svg {
            opacity: 0.6;
        }

        .table-row {
            transition: all 0.2s ease;
            animation: fadeInRow 0.4s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInRow {
            to {
                opacity: 1;
            }
        }

        .table-row:hover {
            background: #f8f9fa;
        }

        .data-table tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f2f6;
            vertical-align: middle;
            font-size: 14px;
        }

        .td-number {
            width: 60px;
        }

        .row-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            font-size: 13px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 15px;
            text-transform: uppercase;
            flex-shrink: 0;
        }

        .user-name {
            font-weight: 500;
            color: #2d3142;
        }

        .nik-badge {
            display: inline-block;
            padding: 6px 12px;
            background: #f1f3f5;
            color: #495057;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            font-family: 'Courier New', monospace;
        }

        .location-tag {
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

        .phone-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #6c757d;
            text-decoration: none;
            transition: color 0.2s;
        }

        .phone-link:hover {
            color: #ff6b35;
        }

        .date-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .date-text {
            color: #2d3142;
            font-weight: 500;
            font-size: 13px;
        }

        .time-text {
            color: #6c757d;
            font-size: 12px;
        }

        /* Empty State */
        .empty-state, .no-results {
            text-align: center;
            padding: 60px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .empty-state svg, .no-results svg {
            color: #dee2e6;
            margin-bottom: 20px;
            width: 64px;
            height: 64px;
        }

        .empty-title, .no-results-title {
            font-size: 18px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 8px;
        }

        .empty-text, .no-results-text {
            color: #adb5bd;
            font-size: 14px;
            margin-bottom: 24px;
            max-width: 400px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .page-title {
                font-size: 24px;
            }

            .stats-bar {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }

            .stat-icon {
                width: 44px;
                height: 44px;
            }

            .stat-value {
                font-size: 20px;
            }
        }

        @media (max-width: 768px) {
            .page-header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-add {
                width: 100%;
                justify-content: center;
            }

            .stats-bar {
                grid-template-columns: 1fr;
            }

            .stat-item {
                padding: 16px;
            }

            .data-card-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 16px 20px;
            }

            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .data-table {
                min-width: 800px;
            }

            .data-table thead th {
                padding: 12px 16px;
                font-size: 11px;
            }

            .data-table tbody td {
                padding: 12px 16px;
                font-size: 13px;
            }

            .user-avatar {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }

            .user-name {
                font-size: 13px;
            }

            .empty-state svg, .no-results svg {
                width: 56px;
                height: 56px;
            }

            .empty-title, .no-results-title {
                font-size: 16px;
            }

            .empty-text, .no-results-text {
                font-size: 13px;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                margin-bottom: 1.5rem;
            }

            .page-title {
                font-size: 22px;
            }

            .page-subtitle {
                font-size: 13px;
            }

            .btn-add {
                padding: 10px 20px;
                font-size: 13px;
            }

            .stat-item {
                padding: 14px;
                gap: 12px;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
            }

            .stat-icon svg {
                width: 18px;
                height: 18px;
            }

            .stat-label {
                font-size: 11px;
            }

            .stat-value {
                font-size: 18px;
            }

            .data-card-header {
                padding: 14px 16px;
            }

            .data-card-title {
                font-size: 15px;
            }

            .result-count {
                font-size: 12px;
            }

            .data-table thead th {
                padding: 10px 12px;
            }

            .data-table tbody td {
                padding: 10px 12px;
            }

            .row-number {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }

            .user-avatar {
                width: 32px;
                height: 32px;
                font-size: 13px;
            }

            .nik-badge {
                font-size: 12px;
                padding: 5px 10px;
            }

            .location-tag {
                font-size: 12px;
                padding: 5px 10px;
            }

            .phone-link {
                font-size: 13px;
            }

            .date-text {
                font-size: 12px;
            }

            .time-text {
                font-size: 11px;
            }

            .empty-state, .no-results {
                padding: 40px 16px;
            }

            .empty-state svg, .no-results svg {
                width: 48px;
                height: 48px;
                margin-bottom: 16px;
            }

            .empty-title, .no-results-title {
                font-size: 15px;
            }

            .empty-text, .no-results-text {
                font-size: 12px;
                margin-bottom: 20px;
            }

            .btn-add-small {
                padding: 8px 16px;
                font-size: 12px;
            }

            .alert-modern {
                padding: 14px 16px;
                gap: 12px;
            }

            .alert-icon {
                width: 36px;
                height: 36px;
            }

            .alert-title {
                font-size: 13px;
            }

            .alert-message {
                font-size: 12px;
            }
        }
    </style>

@endsection
