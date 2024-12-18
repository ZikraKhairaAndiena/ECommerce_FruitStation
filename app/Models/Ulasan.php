<?php

// Ulasan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembelian_id',
        'rating',
        'komentar',
    ];

    public function pembelianProduks()
    {
        return $this->belongsTo(Pembelian::class);
    }
}

