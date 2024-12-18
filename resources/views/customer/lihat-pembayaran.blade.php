@extends('customer.layouts.main')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm mt-4">
        <div class="card-header text-center bg-light">
            <h3 class="mb-0">Detail Pembayaran untuk Order #{{ $pembayaran->pembelian_id }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama Penyetor</th>
                    <td>{{ $pembayaran->nama_penyetor }}</td>
                </tr>
                <tr>
                    <th>Bank</th>
                    <td>{{ $pembayaran->bank }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>{{ $pembayaran->tanggal }}</td>
                </tr>
                <tr>
                    <th>Bukti Pembayaran</th>
                    <td>
                        @if($pembayaran->bukti)
                            <img src="{{ asset('storage/' . $pembayaran->bukti) }}" alt="Bukti Pembayaran" width="200" class="img-thumbnail">
                        @else
                            Tidak ada bukti pembayaran.
                        @endif
                    </td>
                </tr>
            </table>
            <div class="text-center mt-4">
                <a href="{{ route('riwayat.belanja') }}" class="btn btn-primary">Kembali ke Riwayat Belanja</a>
            </div>
        </div>
    </div>
</div>
@endsection
