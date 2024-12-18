@extends('dashboard.layouts.main')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Data Pengguna</h1>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
        <div class="card shadow-sm border rounded">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informasi Pengguna</h5>
            </div>
            <div class="card-body bg-light">

                <div class="mb-3">
                    <label for="name" class="form-label"><i class="fas fa-user"></i> Nama Pengguna</label>
                    <p class="form-control-plaintext border p-2 rounded bg-white">{{ $user->name }}</p>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                    <p class="form-control-plaintext border p-2 rounded bg-white">{{ $user->email }}</p>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label"><i class="fas fa-user-shield"></i> Peran</label>
                    <p class="form-control-plaintext border p-2 rounded bg-white">{{ $user->role }}</p>
                </div>

                <div class="mb-3">
                    <label for="created_at" class="form-label"><i class="fas fa-calendar-alt"></i> Tanggal Dibuat</label>
                    <p class="form-control-plaintext border p-2 rounded bg-white">{{ $user->created_at->format('d-m-Y') }}</p>
                </div>

                <div class="mb-3">
                    <label for="updated_at" class="form-label"><i class="fas fa-calendar-edit"></i> Tanggal Diperbarui</label>
                    <p class="form-control-plaintext border p-2 rounded bg-white">{{ $user->updated_at->format('d-m-Y') }}</p>
                </div>

            </div>
            <div class="card-footer text-end">
                <a href="/dashboard/pengguna" class="btn btn-success btn-sm">Kembali</a>
            </div>
        </div>
    </div>
</div>

@endsection
