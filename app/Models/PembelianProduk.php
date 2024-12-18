<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembelian_id',
        'produk_id',
        'nama_produk',
        'jumlah_produk',
        'harga_produk',
        'coupon_code',
        'subtotal',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
