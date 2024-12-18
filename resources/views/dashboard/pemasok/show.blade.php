@extends('dashboard.layouts.main')

@section('title', 'Detail Pemasok')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Data Pemasok</h1>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
        <div class="card shadow-sm border rounded">
            <div class="card-header bg-light">
                <h5>Informasi Pemasok</h5>
            </div>
            <div class="card-body bg-light">

                <div class="mb-3">
                    <label for="nama_pemasok" class="form-label"><i class="fas fa-truck"></i> <strong>Nama Pemasok</strong></label>
                    <p class="form-control-plaintext">{{ $pemasok->nama_pemasok }}</p>
                </div>

                <div class="mb-3">
                    <label for="no_telepon" class="form-label"><i class="fas fa-phone"></i> <strong>No Telepon</strong></label>
                    <p class="form-control-plaintext">{{ $pemasok->no_telepon }}</p>
                </div>

                <div class="mb-3">
                    <label for="no_rekening" class="form-label"><i class="fas fa-credit-card"></i> <strong>No Rekening</strong></label>
                    <p class="form-control-plaintext">{{ $pemasok->no_rekening }}</p>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label"><i class="fas fa-map-marker-alt"></i> <strong>Alamat</strong></label>
                    <p class="form-control-plaintext">{{ $pemasok->alamat }}</p>
                </div>

            </div>
            <div class="card-footer text-end">
                <a href="{{ route('dashboard.pemasok.index') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>

@endsection