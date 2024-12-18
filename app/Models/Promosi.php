<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{
    // Tentukan tabel yang digunakan oleh model ini (jika berbeda dari nama default)
    protected $table = 'promosis';

    // Tentukan kolom-kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'produk_id',
        'type',
        'description',
        'quantity_required',
        'minimum_purchase_amount',
        'discount_percentage',
        'coupon_code',
        'start_date',
        'end_date',
        'active',
        'applies_to_all',
    ];

    /**
     * Relasi dengan model Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
