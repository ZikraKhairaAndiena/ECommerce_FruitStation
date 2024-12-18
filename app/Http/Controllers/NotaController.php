<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function show($id)
    {
        // Ambil data pembelian beserta produk yang dibeli
        $pembelian = Pembelian::with('ongkir', 'pembelianProduks')->findOrFail($id);

        // Hitung total pembelian dengan memperhitungkan diskon per produk
        $totalPembelian = 0;
        foreach ($pembelian->pembelianProduks as $produk) {
            // Terapkan diskon per produk (jika ada diskon untuk semua produk)
            $hargaSetelahDiskon = $produk->harga_produk - ($pembelian->discount / count($pembelian->pembelianProduks));
            $totalPembelian += $hargaSetelahDiskon * $produk->jumlah_produk;
        }

        // Tampilkan halaman nota dengan data pembelian
        return view('customer.nota', compact('pembelian', 'totalPembelian'));
    }
}
