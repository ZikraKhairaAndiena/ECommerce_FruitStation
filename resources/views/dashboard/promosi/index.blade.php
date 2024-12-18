@extends('dashboard.layouts.main')

@section('title', 'Daftar Promosi')

@section('navPromosi', 'active')

@section('content')

<h1 class="mb-4 text-center text-success">Daftar Promosi Fruit Station</h1>

@if(session('pesan'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
   {{ session('pesan') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Form Pencarian dan Tombol Tambah Promosi Sejajar -->
<div class="d-flex justify-content-between mb-3">
    <div class="d-flex">
    <a href="/promosi/create" class="btn btn-success custom-margin-right">Tambah Promosi</a>
    <a href="{{ route('promosi.cetak-pdf') }}" target="_blank" class="btn btn-custom-green ms-1 d-flex align-items-center justify-content-center p-2" style="width: 40px; height: 40px;">
        <i class="bi bi-file-earmark-pdf fs-4"></i> <!-- Icon PDF with centered alignment and larger size -->
    </a> <!-- Button for print report -->
    </div>
    <form class="d-flex" method="GET" action="{{ route('promosi.index') }}" class="d-flex" style="max-width: 300px; width: 100%;">
        <input class="form-control me-2" type="search" name="search" value="{{ request()->get('search') }}" placeholder="Cari Promosi..." aria-label="Search">
        <button class="btn btn-primary ms-2" type="submit">Cari</button>
    </form>
</div>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Jenis Promosi</th>
            <th>Deskripsi</th>
            <th>Jumlah Minimum</th>
            <th>Jumlah Pembelian Minimum</th>
            <th>Persentase Diskon</th>
            <th>Kode Kupon</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Berakhir</th>
            <th>Status</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($promosis as $promosi)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $promosi->produk_id ? $promosi->produk->nama_produk : 'Semua Produk' }}</td>
            <td>{{ ucfirst(str_replace('_', ' ', $promosi->type)) }}</td>
            <td>{{ $promosi->description }}</td>
            <td>{{ $promosi->quantity_required ?? '-' }}</td>
            <td>{{ $promosi->minimum_purchase_amount !== null ? 'Rp ' . number_format($promosi->minimum_purchase_amount, 0, ',', '.') : '-' }}</td>
            <td>{{ $promosi->discount_percentage }}%</td>
            <td>{{ $promosi->coupon_code ?? '-' }}</td>
            <td>{{ $promosi->start_date }}</td>
            <td>{{ $promosi->end_date }}</td>
            <td>{{ $promosi->active ? 'Aktif' : 'Tidak Aktif' }}</td>
            <td class="text-nowrap text-center" style="width: 120px;">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="/promosi/{{ $promosi->id }}" title="Lihat Detail" class="btn btn-success btn-sm" style="margin-right: 5px; padding: 0.3rem 0.5rem;">
                        <i class="bi bi-eye" style="font-size: 0.8rem;"></i>
                    </a>
                    <a href="/promosi/{{ $promosi->id }}/edit" title="Edit Data" class="btn btn-warning btn-sm" style="margin-right: 5px; padding: 0.3rem 0.5rem;">
                        <i class="bi bi-pencil" style="font-size: 0.8rem;"></i>
                    </a>
                    <form action="/promosi/{{ $promosi->id }}" method="post" class="d-inline">
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
            <li class="page-item {{ $promosis->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $promosis->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $promosis->lastPage(); $i++)
                <li class="page-item {{ ($promosis->currentPage() == $i) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $promosis->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $promosis->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $promosis->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

@endsection
