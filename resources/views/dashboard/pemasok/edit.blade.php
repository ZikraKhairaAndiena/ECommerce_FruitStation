@extends('dashboard.layouts.main')

@section('title', 'Edit Pemasok')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data Pemasok</h1>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
        <form action="{{ route('dashboard.pemasok.update', $pemasok->id) }}" method="POST" class="p-4 border rounded shadow-sm bg-light">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_pemasok" class="form-label"><i class="fas fa-truck"></i> Nama Pemasok</label>
                <input type="text" name="nama_pemasok" class="form-control @error('nama_pemasok') is-invalid @enderror" value="{{ $pemasok->nama_pemasok }}" required>
                @error('nama_pemasok')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_telepon" class="form-label"><i class="fas fa-phone"></i> No Telepon</label>
                <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ $pemasok->no_telepon }}" required>
                @error('no_telepon')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_rekening" class="form-label"><i class="fas fa-credit-card"></i> No Rekening</label>
                <input type="text" name="no_rekening" class="form-control @error('no_rekening') is-invalid @enderror" value="{{ $pemasok->no_rekening }}" required>
                @error('no_rekening')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ $pemasok->alamat }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success">Perbarui Pemasok</button>
            </div>
        </form>
    </div>
</div>

@endsection
