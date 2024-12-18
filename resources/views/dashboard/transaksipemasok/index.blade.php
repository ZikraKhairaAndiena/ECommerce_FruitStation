@extends('dashboard.layouts.main')

@section('title', 'Daftar Transaksi Pemasok')

@section('content')
<h1 class="mb-4 text-center text-success">Daftar Transaksi Pemasok</h1>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Filter dan Cetak PDF -->
<div class="d-flex justify-content-between mb-3 align-items-center">
    <div class="d-flex align-items-center">
        <!-- Tombol Tambah Transaksi -->
        <a href="{{ route('dashboard.transaksipemasok.create') }}" class="btn btn-success custom-margin-right">Tambah Transaksi</a>
        <!-- Form Filter dan Cetak PDF -->
            <form method="GET" action="{{ route('transaksipemasok.cetak-pdf') }}" target="_blank" class="d-flex align-items-center" style="gap: 5px;">
                <!-- Cetak PDF Button -->
                <button class="btn btn-custom-green d-flex align-items-center justify-content-center p-2" style="width: 40px; height: 40px;" type="submit">
                    <i class="bi bi-file-earmark-pdf fs-4"></i>
                </button>

            <!-- Pilihan Bulan -->
            <select class="form-select ms-2" name="bulan">
                <option value="">Pilih Bulan</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request()->get('bulan') == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::createFromFormat('m', $i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <!-- Pilihan Tahun -->
            <select class="form-select ms-2" name="tahun">
                <option value="">Pilih Tahun</option>
                @php
                    $currentYear = date('Y');
                @endphp
                @for ($i = $currentYear; $i >= $currentYear - 10; $i--)
                    <option value="{{ $i }}" {{ request()->get('tahun') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </form>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('dashboard.transaksipemasok.index') }}" class="d-flex" style="max-width: 300px; width: 100%;">
        <input class="form-control me-2" type="search" name="search" value="{{ request()->get('search') }}" placeholder="Cari Transaksi..." aria-label="Search">
        <button class="btn btn-primary ms-2" type="submit">Cari</button>
    </form>
</div>

<!-- Tabel Data Transaksi Pemasok -->
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Pemasok</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Tanggal Transaksi</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaksis as $transaksi)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $transaksi->pemasok->nama_pemasok }}</td>
            <td>{{ $transaksi->produk->nama_produk }}</td>
            <td>{{ $transaksi->jumlah }}</td>
            <td>{{ 'Rp ' . number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            <td>{{ $transaksi->tanggal_transaksi->format('d-m-Y') }}</td>
            <td class="text-nowrap text-center" style="width: 150px;">
                <div class="btn-group" role="group" aria-label="Aksi">
                    <!-- Detail Button -->
                    <a href="{{ route('dashboard.transaksipemasok.show', $transaksi->id) }}" title="Lihat Detail" class="btn btn-success btn-sm" style="margin-right: 5px; padding: 0.3rem 0.5rem;">
                        <i class="bi bi-eye" style="font-size: 0.8rem;"></i>
                    </a>
                    <!-- Edit Button -->
                    <a href="{{ route('dashboard.transaksipemasok.edit', $transaksi->id) }}" title="Edit Data" class="btn btn-warning btn-sm" style="margin-right: 5px; padding: 0.3rem 0.5rem;">
                        <i class="bi bi-pencil" style="font-size: 0.8rem;"></i>
                    </a>
                    <!-- Delete Button -->
                    <form action="{{ route('dashboard.transaksipemasok.destroy', $transaksi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                        @csrf
                        @method('DELETE')
                        <button title="Hapus Data" class="btn btn-danger btn-sm" style="padding: 0.3rem 0.5rem;">
                            <i class="bi bi-trash" style="font-size: 0.8rem;"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $transaksis->links('pagination::bootstrap-4') }}
</div>

@endsection
