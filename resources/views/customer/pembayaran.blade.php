@extends('customer.layouts.main')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm mt-4">
        <div class="card-header text-center bg-light">
            <h2 class="mb-0">Make Payment for Order #{{ $pembelian->id }}</h2>
        </div>
        <div class="card-body">
            <div class="mb-4 text-center">
                <h4>Total Tagihan: <span class="text-success fw-bold">Rp. {{ number_format($pembelian->total_pembelian, 0, ',', '.') }}</span></h4>
            </div>

            <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="pembelian_id" value="{{ $pembelian->id }}">

                <div class="mb-3">
                    <label for="nama_penyetor" class="form-label">Nama Penyetor</label>
                    <input type="text" class="form-control" name="nama_penyetor" placeholder="Masukkan nama penyetor" required>
                </div>

                <div class="mb-3">
                    <label for="bank" class="form-label">Bank</label>
                    <input type="text" class="form-control" name="bank" placeholder="Masukkan nama bank" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" name="jumlah" placeholder="Masukkan jumlah" required>
                </div>

                <div class="mb-3">
                    <label for="bukti" class="form-label">Foto Bukti</label>
                    <input type="file" class="form-control" name="bukti" required>
                    <small class="form-text text-muted">Format yang diterima: JPG, PNG (maks. 2MB).</small>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Kirim Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
