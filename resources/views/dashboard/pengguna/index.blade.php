@extends('dashboard.layouts.main')

@section('title', 'Daftar Pengguna')

@section('content')
<h1 class="mb-4 text-center text-success">Daftar Pengguna</h1>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex justify-content-between mb-3">
    <div class="d-flex">
    <a href="{{ route('dashboard.pengguna.create') }}" class="btn btn-success custom-margin-right">Tambah Pengguna</a>
    <a href="{{ route('pengguna.cetak-pdf') }}" target="_blank" class="btn btn-custom-green ms-1 d-flex align-items-center justify-content-center p-2" style="width: 40px; height: 40px;">
        <i class="bi bi-file-earmark-pdf fs-4"></i> <!-- Icon PDF with centered alignment and larger size -->
    </a> <!-- Button for print report -->
    </div>
<!-- Form Pencarian -->
<form class="d-flex" method="GET" action="{{ route('dashboard.pengguna.index') }}" class="d-flex mb-3" style="max-width: 300px; width: 100%;">
    <input class="form-control me-2" type="search" name="search" value="{{ request()->get('search') }}" placeholder="Cari Pengguna..." aria-label="Search">
    <button class="btn btn-primary ms-2" type="submit">Cari</button>
</form>
</div>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>No Telepon</th>
            <th>Alamat</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td>{{ $user->no_telepon ?? '-' }}</td>
            <td>{{ $user->alamat ?? '-' }}</td>
            <td class="text-nowrap text-center" style="width: 150px;">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <!-- Detail Button -->
                    <a href="{{ route('dashboard.pengguna.show', $user->id) }}" title="Lihat Detail" class="btn btn-success btn-sm" style="margin-right: 5px; padding: 0.3rem 0.5rem;">
                        <i class="bi bi-eye" style="font-size: 0.8rem;"></i>
                    </a>
                    <!-- Edit Button -->
                    <a href="{{ route('dashboard.pengguna.edit', $user->id) }}" title="Edit Data" class="btn btn-warning btn-sm" style="margin-right: 5px; padding: 0.3rem 0.5rem;">
                        <i class="bi bi-pencil" style="font-size: 0.8rem;"></i>
                    </a>
                    <!-- Delete Button (with check for super_admin) -->
                    @if($user->role !== 'super_admin')
                    <form action="{{ route('dashboard.pengguna.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                        @csrf
                        @method('DELETE')
                        <button title="Hapus Data" class="btn btn-danger btn-sm" style="padding: 0.3rem 0.5rem;">
                            <i class="bi bi-trash" style="font-size: 0.8rem;"></i>
                        </button>
                    </form>
                    @else
                    <button title="Tidak Bisa Dihapus" class="btn btn-secondary btn-sm" style="padding: 0.3rem 0.5rem;" disabled>
                        <i class="bi bi-lock" style="font-size: 0.8rem;"></i>
                    </button>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $users->links('pagination::bootstrap-4') }}
</div>

@endsection
