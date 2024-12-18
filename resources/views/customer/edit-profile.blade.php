@extends('customer.layouts.main')

@section('title', 'Edit Profile')

@section('content')
<div class="container my-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0" style="width: 100%; max-width: 600px;">
        <div class="card-header bg-gradient-primary text-white text-center py-4">
            <h3 class="mb-0">Edit Profile</h3>
        </div>
        <div class="card-body px-5 py-4">
            <form action="{{ route('customer.update-profile') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="no_telepon" class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-4">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
