
@extends('layouts.app')

@section('title', 'Dashboard - Perpustakaan')

{{-- Membuka section 'content'. Semua kode di bawah ini akan menjadi konten utama halaman. --}}
@section('content')
    {{-- Bagian ini menampilkan judul utama halaman Dashboard dan pesan selamat datang. --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1" style="font-weight: 700; font-size: 28px; color: #2d3142;">Dashboard</h1>
            <p class="text-muted mb-0" style="font-size: 14px;">Selamat datang kembali!</p>
        </div>
    </div>

    {{-- Baris ini berisi kartu-kartu statistik untuk menampilkan ringkasan data penting. --}}
    <div class="custom-card-row">
        {{-- Kolom untuk kartu statistik pertama. --}}
        <div class="custom-card-column">
            <div class="stats-card stats-card-primary">
                <div class="stats-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                </div>
                <div class="stats-content">
                    <p class="stats-label">Total Buku</p>
                    {{-- Menampilkan variabel $totalBuku yang dikirim dari Controller. --}}
                    <h2 class="stats-value">{{ $totalBuku }}</h2>
                    <div class="stats-badge">
                        <span class="badge badge-success">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Tersedia
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-card-column">
            {{-- Kartu untuk menampilkan jumlah buku yang ditambahkan bulan ini. --}}
            <div class="stats-card stats-card-info">
                <div class="stats-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        <line x1="8" y1="6" x2="16" y2="6"></line>
                        <line x1="8" y1="10" x2="16" y2="10"></line>
                    </svg>
                </div>
                <div class="stats-content">
                    {{-- Menampilkan variabel $namaBulanIni yang dikirim dari Controller. --}}
                    <p class="stats-label">Buku Baru di Bulan {{ $namaBulanIni }}</p>
                    {{-- Menampilkan variabel $jumlahBukuBulanIni yang dikirim dari Controller. --}}
                    <h2 class="stats-value">{{ $jumlahBukuBulanIni }}</h2>
                    <div class="stats-badge">
                        <span class="badge badge-primary">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="18 15 12 9 6 15"></polyline>
                            </svg>
                            Bulan Ini
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card untuk menampilkan tabel data buku yang baru ditambahkan. --}}
    <div class="card-modern">
        <div class="card-modern-header">
            <div>
                <h5 class="mb-1" style="font-weight: 600; color: #2d3142;">Buku Baru Ditambahkan</h5>
                <p class="text-muted mb-0" style="font-size: 13px;">5 pendaftaran buku terakhir</p>
            </div>
            <a href="{{ route('buku.index') }}" class="btn btn-outline-primary">
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
                        <th class="th-number">
                            <div class="th-content">#</div>
                        </th>
                        <th class="th-book-info">
                            <div class="th-content">Kode Buku</div>
                        </th>
                        <th class="th-book-info">
                            <div class="th-content">ISBN</div>
                        </th>
                        <th class="th-book-info">
                            <div class="th-content">Info Buku</div>
                        </th>
                        <th class="th-category">
                            <div class="th-content">Kategori</div>
                        </th>
                        <th class="th-location">
                            <div class="th-content">Lokasi Rak</div>
                        </th>
                        <th class="th-publisher">
                            <div class="th-content">Penerbit</div>
                        </th>
                        <th class="th-date">
                            <div class="th-content">Tanggal Register</div>
                        </th>
                    </tr>
                </thead>
                {{-- Bagian tubuh tabel (table body) yang akan diisi dengan data. --}}
                <tbody id="tableBody">
                    @forelse ($bukuTerbaru as $index => $data)
                        {{-- Atribut data-search digunakan untuk membantu fungsionalitas pencarian (search) dengan JavaScript. --}}
                        <tr class="table-row" data-search="{{ strtolower($data['kode_buku'] . ' ' . $data['penulis'] . ' ' . $data['kategori'] . ' ' . $data['penerbit']) }}">
                            <td class="td-number">
                                {{-- $index dimulai dari 0, jadi kita tambah 1 untuk penomoran yang dimulai dari 1. --}}
                                <span class="row-number">{{ $index + 1 }}</span>
                            </td>
                            <td class="td-kode">
                                <span class="kode-badge">{{ $data['kode_buku'] }}</span>
                            </td>
                            <td class="td-isbn">
                                <span class="isbn-badge">{{ $data['ISBN'] }}</span>
                            </td>
                            <td class="td-book-info">
                                <div class="book-details">
                                    {{-- Menampilkan judul dan penulis buku. --}}
                                    <span class="book-code">{{ $data['judul'] }}</span>
                                    <span class="book-author">{{ $data['penulis'] }}</span>
                                </div>
                            </td>
                            <td class="td-category">
                                <span class="category-badge">{{ $data['kategori'] }}</span>
                            </td>
                            <td class="td-location">
                                <span class="location-tag">{{ $data['lokasi_rak'] }}</span>
                            </td>
                            <td class="td-publisher">
                                <div class="publisher-info">
                                    <span class="publisher-name">{{ $data['penerbit'] }}</span>
                                    <span class="publish-year">Tahun {{ $data['tahun_terbit'] }}</span>
                                </div>
                            </td>
                            <td class="td-date">
                                <div class="date-info">
                                    <span class="date-text">{{ \Carbon\Carbon::parse($data['tanggal_register'])->format('d M Y') }}</span>
                                    <span class="time-text">{{ \Carbon\Carbon::parse($data['tanggal_register'])->format('H:i') }}</span>
                                </div>
                            </td>
                        </tr>
                    {{-- Blok @empty akan dijalankan jika variabel $bukuTerbaru tidak memiliki data (kosong). --}}
                    @empty
                        <tr class="empty-row">
                            <td colspan="7">
                                <div class="empty-state">
                                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                    </svg>
                                    <h5 class="empty-title">Belum Ada Data Buku</h5>
                                    <p class="empty-text">Mulai tambahkan data buku dengan klik tombol "Tambah Buku" di atas</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
