@extends('customer.layouts.main')

@section('content')
<div class="container py-5" style="padding-top: 100px;">
    <div class="card shadow-sm mt-4">
        <div class="card-header text-center bg-light">
            <h3 class="mb-0">Riwayat Belanja {{ $user->name }}</h3>
        </div>
        <div class="card-body">
            @if($pembelian->isEmpty())
                <div class="text-center py-5">
                    <h4>Anda belum pernah melakukan pemesanan, silahkan belanja.</h4>
                    <a href="{{ url('customer/home') }}" class="btn btn-primary mt-3">Belanja Sekarang</a>
                </div>
            @else
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Detail Produk</th>
                                <th>Opsi</th>
                                <th>Ulasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelian as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pembelian)->format('Y-m-d') }}</td>
                                    <td>
                                        {{ $item->status_pembelian }}
                                        <br>
                                        @if (!empty($item->resi_pengiriman))
                                            <small class="text-muted">Resi: {{ $item->resi_pengiriman }}</small>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->total_pembelian, 0, ',', '.') }}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            @foreach($item->pembelianProduks as $pembelianProduks)
                                                <li>{{ $pembelianProduks->nama_produk }} - Jumlah: {{ $pembelianProduks->jumlah_produk }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between button-group">
                                            <a href="{{ route('nota', ['id' => $item->id]) }}" class="btn btn-info me-1">Nota</a>
                                            @if ($item->status_pembelian == "pending")
                                                <a href="{{ route('input.pembayaran', ['id' => $item->id]) }}" class="btn btn-success me-1">Input Pembayaran</a>
                                            @elseif (in_array($item->status_pembelian, ["sudah kirim pembayaran", "barang dikirim", "selesai"]))
                                                <a href="{{ route('lihat.pembayaran', ['id' => $item->id]) }}" class="btn btn-warning me-1">Lihat Pembayaran</a>
                                            @endif
                                            @if ($item->status_pembelian == "selesai")
                                                @if ($item->ulasan)
                                                    <span class="btn btn-secondary">Ulasan Diberikan</span>
                                                @else
                                                    <a href="{{ route('input.ulasan', ['id' => $item->id]) }}" class="btn btn-primary">Beri Ulasan</a>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->ulasan)
                                            <div>
                                                <strong>Rating:</strong>
                                                <div class="rating-stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= $item->ulasan->rating ? 'fas' : 'far' }} fa-star" style="color: gold;"></i>
                                                    @endfor
                                                </div>
                                                <br>
                                                <strong>Komentar:</strong> {{ $item->ulasan->komentar }}
                                            </div>
                                        @else
                                            <span>Belum ada ulasan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
