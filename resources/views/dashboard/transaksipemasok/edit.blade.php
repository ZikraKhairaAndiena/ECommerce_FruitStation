@extends('dashboard.layouts.main')

@section('title', 'Edit Transaksi Pemasok')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data Transaksi Pemasok</h1>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
        <form action="{{ route('dashboard.transaksipemasok.update', $transaksi->id) }}" method="post" class="p-4 border rounded shadow-sm bg-light">
            @method('PUT')
            @csrf

            <div class="mb-3">
                <label for="pemasok_id" class="form-label"><i class="fas fa-user"></i> Pemasok</label>
                <select name="pemasok_id" class="form-select @error('pemasok_id') is-invalid @enderror" required>
                    @foreach($pemasok as $pemasokItem)
                    <option value="{{ $pemasokItem->id }}" {{ old('pemasok_id', $transaksi->pemasok_id) == $pemasokItem->id ? 'selected' : '' }}>{{ $pemasokItem->nama_pemasok }}</option>
                    @endforeach
                </select>
                @error('pemasok_id')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="produk_id" class="form-label"><i class="fas fa-box"></i> Produk</label>
                <select name="produk_id" class="form-select @error('produk_id') is-invalid @enderror" required>
                    @foreach($produk as $produkItem)
                    <option value="{{ $produkItem->id }}" {{ old('produk_id', $transaksi->produk_id) == $produkItem->id ? 'selected' : '' }}>{{ $produkItem->nama_produk }}</option>
                    @endforeach
                </select>
                @error('produk_id')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label"><i class="fas fa-cogs"></i> Jumlah</label>
                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" id="jumlah" value="{{ old('jumlah', $transaksi->jumlah) }}" required>
                @error('jumlah')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="total_harga" class="form-label"><i class="fas fa-cogs"></i> Total Harga</label>
                <input type="number" class="form-control @error('total_harga') is-invalid @enderror" name="total_harga" id="total_harga" value="{{ old('total_harga', $transaksi->total_harga) }}" required>
                @error('total_harga')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_transaksi" class="form-label"><i class="fas fa-calendar-alt"></i> Tanggal Transaksi</label>
                <input type="date" class="form-control @error('tanggal_transaksi') is-invalid @enderror" name="tanggal_transaksi" id="tanggal_transaksi" value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi->format('Y-m-d')) }}" required>
                @error('tanggal_transaksi')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection
