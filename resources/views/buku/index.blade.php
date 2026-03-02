@extends('layouts.app')

@section('title', 'Data Buku - Perpustakaan')

@section('content')
    <!-- Header Section -->
    <div class="page-header mb-4">
        <div class="page-header-content">
            <div>
                <h1 class="mb-1" style="font-weight: 700; font-size: 28px; color: #2d3142;">Data Buku Perpustakaan</h1>
                <p class="text-muted mb-0" style="font-size: 14px;">Kelola data buku Perpustakaan</p>

            </div>
            <a href="{{ route('buku.create') }}" class="btn-add">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Tambah buku
            </a>
        </div>
    </div>

    <!-- Success Alert -->
    {{-- @if (session('success'))
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
    @endif --}}

    <!-- Stats Bar -->
    <div class="stats-bar mb-4">
        <div class="stat-item">
            <div class="stat-icon stat-icon-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Buku</p>
                <h3 class="stat-value" id="totalCount">{{ count($buku) }}</h3>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon stat-icon-info">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <line x1="12" y1="14" x2="12" y2="20"></line>
                    <line x1="9" y1="17" x2="15" y2="17"></line>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Penambahan Buku Hari Ini</p>
                <h3 class="stat-value">{{ $jumlahBukuHariIni }}</h3>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="data-card">
        <div class="data-card-header">
            <h5 class="data-card-title">Daftar Buku Perpustakaan</h5>
            <span class="result-count" id="resultCount">Menampilkan {{ count($buku) }} data</span>
        </div>

        <div class="table-container">
            <table class="data-table" id="bukuTable">
                <thead>
                    <tr>
                        <th class="th-number">
                            <div class="th-content">#</div>
                        </th>
                        <th class="th-book-info">
                            <div class="th-content">
                                Kode Buku
                            </div>
                        </th>
                        <th class="th-book-info">
                            <div class="th-content">
                                ISBN
                            </div>
                        </th>
                        <th class="th-book-info">
                            <div class="th-content">
                                Info Buku
                            </div>
                        </th>
                        <th class="th-category">
                            <div class="th-content">
                                Kategori
                            </div>
                        </th>
                        <th class="th-location">
                            <div class="th-content">
                                Lokasi Rak
                            </div>
                        </th>
                        <th class="th-publisher">
                            <div class="th-content">
                                Penerbit
                            </div>
                        </th>
                        <th class="th-date">
                            <div class="th-content">
                                Tanggal Register
                            </div>
                        </th>
                        <th class="th-actions">
                            <div class="th-content">
                                Aksi
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse ($buku as $index => $data)
                        <tr class="table-row" data-search="{{ strtolower($data['kode_buku'] . ' ' . $data['penulis'] . ' ' . $data['kategori'] . ' ' . $data['penerbit']) }}">
                            <td class="td-number">
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
                                    <span class="book-code">{{ $data['judul'] }}</span>
                                    <span class="book-author">{{ $data['penulis'] }}</span>
                                </div>
                            </td>
                            <td class="td-category">
                                <span class="category-badge">{{ $data['kategori'] }}</span>
                            </td>
                            <td class="td-location">
                                <span class="location-tag">
                                    {{ $data['lokasi_rak'] }}
                                </span>
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
                            <td class="td-actions">
                                <div class="action-buttons">
                                    <a href="{{ route('buku.edit', $data['kode_buku']) }}" class="btn-outline-primary btn-action btn-edit">Edit</a>
                                    <form action="{{ route('buku.destroy', $data['kode_buku']) }}" method="POST" class="form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-outline-primary btn-action btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tombolHapus = document.querySelectorAll('.form-hapus button[type="submit"]');

            tombolHapus.forEach(tombol => {
                tombol.addEventListener('click', function (e) {
                    e.preventDefault(); // Mencegah form dikirim langsung

                    const form = this.closest('form'); // Cari form terdekat

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data buku ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ff6b35',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Jika dikonfirmasi, kirim formnya
                        }
                    });
                });
            });
        });
    </script>
@endsection
