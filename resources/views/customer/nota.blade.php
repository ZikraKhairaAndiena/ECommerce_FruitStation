@extends('customer.layouts.main')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="font-weight-bold text-info">Nota Pembelian</h2>
        <h5>ID Pembelian: <span class="text-primary">{{ $pembelian->id }}</span></h5>
        <h5>Tanggal Pembelian: <span class="text-primary">{{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d-m-Y') }}</span></h5>
        <h5>Status Pembelian: <span class="text-primary">{{ ucfirst($pembelian->status_pembelian) }}</span></h5>
    </div>

    <hr class="my-4">

    <div class="customer-info mb-4">
        <h4 class="font-weight-bold text-success">Informasi Customer:</h4>
        <div class="border p-3 rounded bg-light shadow-sm">
            <p><strong>Nama:</strong> <span class="text-secondary">{{ $pembelian->user->name }}</span></p>
            <p><strong>No Telepon:</strong> <span class="text-secondary">{{ $pembelian->user->no_telepon }}</span></p>
            <p><strong>Email:</strong> <span class="text-secondary">{{ $pembelian->user->email }}</span></p>
        </div>
    </div>

    <h4 class="font-weight-bold text-success">Rincian Produk:</h4>
    <div class="table-responsive mb-4">
        <table class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $totalSubtotal = 0; @endphp
                @foreach($pembelian->pembelianProduks as $produk)
                    @php
                        $diskonPerProduk = $pembelian->discount / count($pembelian->pembelianProduks);
                        $hargaSetelahDiskon = $produk->harga_produk - $diskonPerProduk;
                        $subtotal = $hargaSetelahDiskon * $produk->jumlah_produk;
                        $totalSubtotal += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->jumlah_produk }}</td>
                        <td>Rp{{ number_format($produk->harga_produk, 2, ',', '.') }}</td>
                        <td>Rp{{ number_format($diskonPerProduk, 2, ',', '.') }}</td>
                        <td>Rp{{ number_format($subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-4">
        <h5 class="font-weight-bold text-success">Rincian Pembayaran:</h5>
        <div class="border p-3 rounded bg-light shadow-sm">
            <h5>Subtotal Produk: <span class="text-primary">Rp{{ number_format($totalSubtotal, 2, ',', '.') }}</span></h5>
            <h5>Ongkos Kirim: <span class="text-primary">Rp{{ number_format($pembelian->tarif, 2, ',', '.') }}</span></h5>
            <h5>Diskon: <span class="text-primary">Rp{{ number_format($pembelian->discount, 2, ',', '.') }}</span></h5>
            <h5>Total Pembelian: <span class="text-danger">Rp{{ number_format($totalSubtotal + $pembelian->tarif, 2, ',', '.') }}</span></h5>
            <div class="d-flex justify-content-between mt-3">
                <h5 class="font-weight-bold">Alamat Pengiriman:</h5>
                <div class="border p-2 rounded bg-light" style="font-size: 1.1em; flex: 1; margin-left: 10px;">
                    <strong>{{ $pembelian->alamat_pengiriman }}</strong>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="payment-info bg-light p-4 rounded shadow-sm border p-3">
        <h4 class="font-weight-bold">Silahkan melakukan pembayaran</h4>
        <h5 class="font-weight-bold">Jumlah: <span class="text-danger">Rp{{ number_format($totalSubtotal + $pembelian->tarif, 2, ',', '.') }}</span></h5>
        <h5 class="font-weight-bold">Ke-> <span class="text-success">BANK BRI 547-90102890-9539</span></h5>
        <h5 class="font-weight-bold">AN. <span class="text-success">FruitStation Padang</span></h5>
    </div>
</div>
@endsection
