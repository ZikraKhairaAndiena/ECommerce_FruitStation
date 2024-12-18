@extends('dashboard.layouts.main')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data Kategori</h1>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
        <form action="/kategori/{{ $kategori->id }}" method="post" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-light">
            @method('PUT')
            @csrf

            <div class="mb-3">
                <label for="nama_kategori" class="form-label"><i class="fas fa-tag"></i>Nama Kategori</label>
                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" placeholder="Masukkan Nama Kategori">
                @error('nama_kategori')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success">Perbarui Produk</button>
            </div>
        </form>
    </div>
</div>

@endsection
