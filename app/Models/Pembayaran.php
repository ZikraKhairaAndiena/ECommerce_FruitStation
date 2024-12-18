<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembelian_id',
        'nama_penyetor',
        'bank',
        'jumlah',
        'tanggal',
        'bukti',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}
