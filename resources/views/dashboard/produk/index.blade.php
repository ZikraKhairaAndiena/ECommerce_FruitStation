@extends('dashboard.layouts.main')

@section('title', 'Daftar Produk')

@section('navMhs', 'active')

@section('content')

<h1 class="mb-4 text-center text-success">Daftar Produk Fruit Station</h1>

@if(session('pesan'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
   {{ session('pesan') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex justify-content-between mb-3">
    <div class="d-flex">
        <a href="/produk/create" class="btn btn-success custom-margin-right">Tambah Produk</a> <!-- Menambahkan custom class -->
        <a href="{{ route('produk.cetak-pdf') }}" target="_blank" class="btn btn-custom-green ms-1 d-flex align-items-center justify-content-center p-2" style="width: 40px; height: 40px;">
            <i class="bi bi-file-earmark-pdf fs-4"></i> <!-- Icon PDF with centered alignment and larger size -->
        </a> <!-- Button for print report -->
    </div>
    <form class="d-flex" method="GET" action="{{ url('/produk') }}">
        <input class="form-control me-2" type="search" name="search" value="{{ request()->get('search') }}" placeholder="Cari Produk..." aria-label="Search">
        <button class="btn btn-primary ms-2" type="submit">Cari</button>
    </form>
</div>


<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Produk ID</th>
            <th>Kategori</th>
            <th>Nama Produk</th>
            <th>Stok Produk</th>
            <th>Satuan</th>
            <th>Harga Produk</th>
            <th>Deskripsi Produk</th>
            <th>Gambar Produk</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produks as $produk)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $produk->produk_id }}</td>
            <td>{{ $produk->kategori->nama_kategori }}</td>
            <td>{{ $produk->nama_produk }}</td>
            <td>{{ $produk->stok_produk }}</td>
            <td>{{ $produk->satuan }}</td>
            <td>Rp {{ number_format($produk->harga_produk, 2, ',', '.') }}</td>
            <td>{{ $produk->deskripsi_produk }}</td>
            <td>
                @if($produk->gambar_produk)
                    <img src="{{ asset('img/' . $produk->gambar_produk) }}" alt="{{ $produk->nama_produk }}" style="width:100px;">
                @else
                    <p class="text-muted">No Image Available</p>
                @endif
            </td>
            <td class="text-nowrap text-center" style="width: 120px;">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="/produk/{{ $produk->id }}" title="Lihat Detail" class="btn btn-success btn-sm" style="margin-right: 5px; padding: 0.3rem 0.5rem;">
                        <i class="bi bi-eye" style="font-size: 0.8rem;"></i>
                    </a>
                    <a href="/produk/{{ $produk->id }}/edit" title="Edit Data" class="btn btn-warning btn-sm" style="margin-right: 5px; padding: 0.3rem 0.5rem;">
                        <i class="bi bi-pencil" style="font-size: 0.8rem;"></i>
                    </a>
                    <form action="/produk/{{ $produk->id }}" method="post" class="d-inline">
                        @method('DELETE')
                        @csrf
                        <button title="Hapus Data" class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data ini?')" style="padding: 0.3rem 0.5rem;">
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
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item {{ $produks->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $produks->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $produks->lastPage(); $i++)
                <li class="page-item {{ ($produks->currentPage() == $i) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $produks->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $produks->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $produks->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

@endsection
