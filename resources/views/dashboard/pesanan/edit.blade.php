@extends('dashboard.layouts.main')

@section('title', 'Edit Pesanan')

@section('content')
<h1 class="mb-4">Edit Pesanan</h1>

<form action="{{ route('dashboard.pesanan.update', $pesanan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card mb-4 shadow">
        <div class="card-header bg-success text-white">
            <h5>Informasi Pesanan</h5>
        </div>
        <div class="card-body">
            {{-- Customer Name --}}
            <div class="mb-3">
                <label for="user" class="form-label">Customer</label>
                <input type="text" id="user" class="form-control" value="{{ $pesanan->user->name }}" readonly>
            </div>

            {{-- Ongkir --}}
            <div class="mb-3">
                <label for="ongkir" class="form-label">Ongkir</label>
                <input type="text" id="ongkir" class="form-control" value="Rp {{ number_format($pesanan->ongkir->tarif, 2, ',', '.') }}" readonly>
            </div>

            {{-- Tanggal Pembelian --}}
            <div class="mb-3">
                <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                <input type="text" id="tanggal_pembelian" class="form-control" value="{{ \Carbon\Carbon::parse($pesanan->tanggal_pembelian)->format('Y-m-d') }}" readonly>
            </div>

            {{-- Total Pembelian --}}
            <div class="mb-3">
                <label for="total_pembelian" class="form-label">Total Pembelian</label>
                <input type="text" id="total_pembelian" class="form-control" value="Rp {{ number_format($pesanan->total_pembelian, 2, ',', '.') }}" readonly>
            </div>

            {{-- Alamat Pengiriman --}}
            <div class="mb-3">
                <label for="alamat_pengiriman" class="form-label">Alamat Pengiriman</label>
                <input type="text" id="alamat_pengiriman" class="form-control" value="{{ $pesanan->alamat_pengiriman }}" readonly>
            </div>

            {{-- Status Pembelian: Hanya untuk Role "Kurir" --}}
            @if(Auth::user()->role === 'kurir')
            <div class="mb-3">
                <label for="status_pembelian" class="form-label">Status Pembelian</label>
                <select name="status_pembelian" id="status_pembelian" class="form-control">
                    <option value="barang dikirim" {{ $pesanan->status_pembelian == 'barang dikirim' ? 'selected' : '' }}>Barang Dikirim</option>
                    <option value="selesai" {{ $pesanan->status_pembelian == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ $pesanan->status_pembelian == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
                @error('status_pembelian')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            @else
            <div class="mb-3">
                <label for="status_pembelian" class="form-label">Status Pembelian</label>
                <input type="text" id="status_pembelian" class="form-control" value="{{ ucfirst($pesanan->status_pembelian) }}" readonly>
            </div>
            @endif

            {{-- Resi Pengiriman: Hanya untuk Role "Admin" --}}
            @if(Auth::user()->role === 'admin')
            <div class="mb-3">
                <label for="resi_pengiriman" class="form-label">Resi Pengiriman</label>
                <input type="text" name="resi_pengiriman" id="resi_pengiriman" class="form-control" value="{{ old('resi_pengiriman', $pesanan->resi_pengiriman) }}">
                @error('resi_pengiriman')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            @else
            <div class="mb-3">
                <label for="resi_pengiriman" class="form-label">Resi Pengiriman</label>
                <input type="text" id="resi_pengiriman" class="form-control" value="{{ $pesanan->resi_pengiriman }}" readonly>
            </div>
            @endif
        </div>
    </div>

    {{-- Submit and Back Buttons --}}
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('dashboard.pesanan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
