@extends('dashboard.layouts.main')

@section('title', 'Daftar Pesanan')

@section('content')

<h1 class="mb-4 text-center text-success">Daftar Pesanan Fruit Station</h1>

@if(session('pesan'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('pesan') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Buttons for Add, Filter, and Print Report -->
<div class="d-flex justify-content-between mb-3 align-items-center">
    <!-- Cetak Laporan Button with PDF Icon -->
    <div class="d-flex align-items-center">
        <form method="GET" action="{{ route('pesanan.cetak-pdf') }}" target="_blank" class="d-flex align-items-center" style="gap: 5px;">
            <!-- Cetak PDF Button -->
            <button class="btn btn-custom-green d-flex align-items-center justify-content-center p-2" style="width: 40px; height: 40px;" type="submit">
                <i class="bi bi-file-earmark-pdf fs-4"></i>
            </button>

            <!-- Month Selection -->
            <select class="form-select ms-2" name="bulan" style="max-width: 120px;">
                <option value="">Pilih Bulan</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request()->get('bulan') == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>

            <!-- Year Selection -->
            <select class="form-select ms-2" name="tahun" style="max-width: 120px;">
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
    <form method="GET" action="{{ route('dashboard.pesanan.index') }}" class="d-flex">
        <div class="d-flex" style="max-width: 300px; width: 100%;">
            <input class="form-control me-2" type="search" name="search" value="{{ request()->get('search') }}" placeholder="Cari Pesanan..." aria-label="Search">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>
</div>


<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Customer</th>
            <th>Ongkir</th>
            <th>Tanggal Pembelian</th>
            <th>Total Pembelian</th>
            <th>Alamat Pengiriman</th>
            <th>Status Pembelian</th>
            <th>Resi Pengiriman</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pesanans as $pesanan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pesanan->user->name }}</td> <!-- Menampilkan nama pengguna -->
            <td>Rp {{ number_format($pesanan->ongkir->tarif, 2, ',', '.') }}</td> <!-- Menampilkan tarif ongkir -->
            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pembelian)->format('Y-m-d') }}</td> <!-- Mengubah format tanggal -->
            <td>Rp {{ number_format($pesanan->total_pembelian, 2, ',', '.') }}</td>
            <td>{{ $pesanan->alamat_pengiriman }}</td>
            <td>{{ ucfirst($pesanan->status_pembelian) }}</td>
            <td>{{ $pesanan->resi_pengiriman ?? 'N/A' }}</td>
            <td class="text-center">
                <a href="{{ route('dashboard.pesanan.show', $pesanan->id) }}" title="Lihat Detail" class="btn btn-success btn-sm" style="padding: 0.3rem 0.5rem;">
                    <i class="bi bi-eye icon-spacing" style="font-size: 0.8rem;"></i>
                </a>
                <a href="{{ route('dashboard.pesanan.edit', $pesanan->id) }}" title="Edit Data" class="btn btn-warning btn-sm" style="padding: 0.3rem 0.5rem;">
                    <i class="bi bi-pencil icon-spacing" style="font-size: 0.8rem;"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $pesanans->links('pagination::bootstrap-4') }}
</div>

@endsection
