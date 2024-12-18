@extends('dashboard.layouts.main')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data Promosi</h1>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
        <form action="/promosi/{{ $promosi->id }}" method="post" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-light">
            @method('PUT')
            @csrf

            <div class="mb-3">
                <label for="produk_id" class="form-label"><i class="fas fa-tag"></i> Produk ID</label>
                <select name="produk_id" class="form-select @error('produk_id') is-invalid @enderror">
                    <option value="">Pilih Produk</option>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}"
                            @if(old('produk_id', $promosi->produk_id) == $produk->id) selected @endif>
                            {{ $produk->nama_produk }}
                        </option>
                    @endforeach
                </select>
                @error('produk_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="applies_to_all" class="form-label"><i class="fas fa-check-circle"></i> Berlaku untuk Semua Produk</label>
                <input type="checkbox" class="form-check-input @error('applies_to_all') is-invalid @enderror" name="applies_to_all" id="applies_to_all" value="1"
                    @if(old('applies_to_all', $promosi->applies_to_all) == 1) checked @endif>
                @error('applies_to_all')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-tags"></i> Jenis Promosi</label>
                <select name="type" class="form-select @error('type') is-invalid @enderror">
                    <option value="quantity_discount" @if(old('type', $promosi->type) == 'quantity_discount') selected @endif>Quantity Discount</option>
                    <option value="coupon" @if(old('type', $promosi->type) == 'coupon') selected @endif>Coupon</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label"><i class="fas fa-info-circle"></i> Deskripsi Promosi</label>
                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{ old('description', $promosi->description) }}" placeholder="Masukkan Deskripsi Promosi">
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quantity_required" class="form-label"><i class="fas fa-shopping-cart"></i> Jumlah Pembelian Minimum (Quantity Discount)</label>
                <input type="number" class="form-control @error('quantity_required') is-invalid @enderror" name="quantity_required" id="quantity_required" value="{{ old('quantity_required', $promosi->quantity_required) }}" placeholder="Masukkan Jumlah Pembelian Minimum">
                @error('quantity_required')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="minimum_purchase_amount" class="form-label"><i class="fas fa-money-bill-wave"></i> Jumlah Pembelian Minimum (Coupon)</label>
                <input type="number" class="form-control @error('minimum_purchase_amount') is-invalid @enderror" name="minimum_purchase_amount" id="minimum_purchase_amount" value="{{ old('minimum_purchase_amount', $promosi->minimum_purchase_amount) }}" placeholder="Masukkan Jumlah Pembelian Minimum untuk Diskon">
                @error('minimum_purchase_amount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="discount_percentage" class="form-label"><i class="fas fa-percent"></i> Persentase Diskon</label>
                <input type="number" class="form-control @error('discount_percentage') is-invalid @enderror" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $promosi->discount_percentage) }}" placeholder="Masukkan Persentase Diskon">
                @error('discount_percentage')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="coupon_code" class="form-label"><i class="fas fa-key"></i> Kode Kupon</label>
                <input type="text" class="form-control @error('coupon_code') is-invalid @enderror" name="coupon_code" id="coupon_code" value="{{ old('coupon_code', $promosi->coupon_code) }}" placeholder="Masukkan Kode Kupon">
                @error('coupon_code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label"><i class="fas fa-calendar"></i> Tanggal Mulai</label>
                <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{ old('start_date', $promosi->start_date) }}">
                @error('start_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label"><i class="fas fa-calendar"></i> Tanggal Berakhir</label>
                <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ old('end_date', $promosi->end_date) }}">
                @error('end_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="active" class="form-label"><i class="fas fa-toggle-on"></i> Status Aktif</label>
                <select name="active" class="form-select @error('active') is-invalid @enderror">
                    <option value="1" {{ old('active', $promosi->active) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('active', $promosi->active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('active')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success">Perbarui Promosi</button>
            </div>
        </form>
    </div>
</div>

@endsection
