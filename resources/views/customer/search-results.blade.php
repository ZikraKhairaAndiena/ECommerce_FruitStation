@extends('customer.layouts.main')
@section('title', 'Hasil Pencarian Produk')

@section('content')
<h1 class="mb-4">Hasil Pencarian untuk "{{ request()->input('query') }}"</h1>

@if(session('pesan'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
   {{ session('pesan') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($produk->isEmpty())
    <p>No products found.</p>
@else
    <div class="tab-content">
        <div id="tab-1" class="tab-pane fade show p-0 active">
            <div class="row g-4">
                @foreach($produk as $item)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="rounded position-relative fruite-item">
                        <div class="fruite-img">
                            <a href="{{ url('customer/product/' . $item->id) }}">
                                <img src="{{ asset('img/' . $item->gambar_produk) }}" class="img-fluid w-100 rounded-top" alt="{{ $item->nama_produk }}">
                            </a>
                        </div>
                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div>
                        <div class="p-4 border border-secondary border-top-0 rounded-bottom text-center">
                            <h4>{{ $item->nama_produk }}</h4>
                            {{-- <p>{{ $item->deskripsi_produk }}</p> --}}
                            <div class="d-flex justify-content-center flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">Rp{{ number_format($item->harga_produk) }} / {{ $item->satuan }}</p>
                            </div>
                            <p class="text-muted mb-2">Stock: {{ $item->stok_produk }} kg</p>
                            @if(Auth::check())
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary mt-2">
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                </a>
                            @else
                                <button class="btn border border-secondary rounded-pill px-3 text-primary mt-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@endsection
