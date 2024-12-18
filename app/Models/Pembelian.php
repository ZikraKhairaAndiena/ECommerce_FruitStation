<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ongkir_id',
        'tanggal_pembelian',
        'total_pembelian',
        'nama_kota',
        'discount',
        'tarif',
        'alamat_pengiriman',
        'status_pembelian',
        'resi_pengiriman',
    ];

    // Menentukan nama tabel jika berbeda dari konvensi
    // protected $table = 'pembelian'; // Uncomment jika nama tabel berbeda

    protected $casts = [
        'tanggal_pembelian' => 'datetime',
    ];

    public function ongkir()
    {
        return $this->belongsTo(Ongkir::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'pembelian_id');
    }

    public function pembelianProduks()
    {
        return $this->hasMany(PembelianProduk::class, 'pembelian_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class);
    }
}
