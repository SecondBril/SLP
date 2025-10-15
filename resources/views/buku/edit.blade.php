@extends('layouts.app')

@section('title', 'Edit Data Buku')

@section('content')
    {{-- 1. Mengubah Judul dan Deskripsi Halaman --}}
    <div class="page-header mb-4">
        <div class="page-header-content">
            <div>
                <h1 class="mb-1" style="font-weight: 700; font-size: 28px; color: #2d3142;">Edit Data Buku: {{ $buku['kode_buku'] }}</h1>
                <p class="text-muted mb-0" style="font-size: 14px;">Perbarui formulir di bawah untuk mengubah data buku.</p>
            </div>
        </div>
    </div>

    <hr class="mb-4">

    <div class="data-card">
        {{-- 2. Mengubah Action Form dan Menambahkan Method PUT --}}
        <form action="{{ route('buku.update', $buku['kode_buku']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-body">
                <div class="form-grid ">

                    {{-- 3. Menambahkan Field Kode Buku (Read-Only) --}}
                    <div class="form-group grid-full-width">
                        <label for="kode_buku" class="form-label">Kode Buku</label>
                        <input type="text" class="form-control" id="kode_buku" name="kode_buku" value="{{ $buku['kode_buku'] }}" readonly>
                        <small class="form-text text-muted">Kode buku tidak dapat diubah.</small>
                    </div>

                    {{-- 4. Mengisi Otomatis Setiap Input dengan Data yang Ada --}}
                    <div class="form-group">
                        <label for="ISBN" class="form-label">ISBN</label>
                        <input type="text" class="form-control @error('ISBN') is-invalid @enderror" id="ISBN" name="ISBN" value="{{ old('ISBN', $buku['ISBN']) }}" placeholder="Contoh: 978-602-03-2478-4" required minlength="10">
                        @error('ISBN')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="judul" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $buku['judul']) }}" placeholder="Masukkan judul buku" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group grid-full-width">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                            <option value="" disabled>Pilih salah satu kategori...</option>
                            <option value="Fiksi" {{ old('kategori', $buku['kategori']) == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                            <option value="Non-Fiksi" {{ old('kategori', $buku['kategori']) == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                            <option value="Sains & Teknologi" {{ old('kategori', $buku['kategori']) == 'Sains & Teknologi' ? 'selected' : '' }}>Sains & Teknologi</option>
                            <option value="Sejarah" {{ old('kategori', $buku['kategori']) == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                            <option value="Pengembangan Diri" {{ old('kategori', $buku['kategori']) == 'Pengembangan Diri' ? 'selected' : '' }}>Pengembangan Diri</option>

                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control @error('penulis') is-invalid @enderror" id="penulis" name="penulis" value="{{ old('penulis', $buku['penulis']) }}" placeholder="Masukkan nama penulis" required>
                        @error('penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="penerbit" class="form-label">Penerbit</label>
                        <input type="text" class="form-control @error('penerbit') is-invalid @enderror" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku['penerbit']) }}" placeholder="Masukkan nama penerbit" required>
                        @error('penerbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku['tahun_terbit']) }}" placeholder="Contoh: 2023" required maxlength="4">
                        @error('tahun_terbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lokasi_rak" class="form-label">Lokasi Rak</label>
                        <input type="text" class="form-control @error('lokasi_rak') is-invalid @enderror" id="lokasi_rak" name="lokasi_rak" value="{{ old('lokasi_rak', $buku['lokasi_rak']) }}" placeholder="Contoh: A1-03" required>
                        @error('lokasi_rak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
                {{-- 5. Mengubah Teks Tombol Aksi --}}
                <button type="submit" class="btn btn-primary">
                    Update Data
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')

<script>
    // Tahun Terbit validation - only numbers
    document.getElementById('tahun_terbit').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-4]/g, '');
    })
</script>
@endsection
