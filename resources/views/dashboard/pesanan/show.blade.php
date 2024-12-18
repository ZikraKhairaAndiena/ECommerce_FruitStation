@extends('dashboard.layouts.main')

@section('title', 'Detail Pesanan')

@section('content')
<h1 class="mb-4 text-center text-success">Detail Pesanan</h1>

<div class="card shadow-lg border-0 rounded-lg">
    <div class="card-header bg-gradient-success text-white rounded-top">
        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Pesanan</h5>
    </div>
    <div class="card-body p-4">
        <div class="row mb-3">
            <div class="col-md-4"><strong>Customer:</strong></div>
            <div class="col-md-8 text-muted">{{ $pesanan->user->name }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Ongkir:</strong></div>
            <div class="col-md-8 text-muted">Rp {{ number_format($pesanan->ongkir->tarif, 2, ',', '.') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Tanggal Pembelian:</strong></div>
            <div class="col-md-8 text-muted">{{ \Carbon\Carbon::parse($pesanan->tanggal_pembelian)->format('Y-m-d') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Total Pembelian:</strong></div>
            <div class="col-md-8 text-muted">Rp {{ number_format($pesanan->total_pembelian, 2, ',', '.') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Alamat Pengiriman:</strong></div>
            <div class="col-md-8 text-muted">{{ $pesanan->alamat_pengiriman }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Status Pembelian:</strong></div>
            <div class="col-md-8 text-muted">{{ ucfirst($pesanan->status_pembelian) }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Resi Pengiriman:</strong></div>
            <div class="col-md-8 text-muted">{{ $pesanan->resi_pengiriman ?? 'N/A' }}</div>
        </div>
    </div>
</div>

<div class="text-center mt-5">
    <a href="{{ route('dashboard.pesanan.index') }}"
       class="btn btn-success btn-lg shadow-sm border-0 rounded-pill px-4 py-2 text-white"
       style="background: linear-gradient(135deg, #34d058, #28a745); transition: all 0.3s;">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

@endsection
