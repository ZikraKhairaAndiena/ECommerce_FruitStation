<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // 1. Fetch Top 5 Produk Terlaris
        $produkTerlaris = Produk::select('id', 'nama_produk', 'gambar_produk') // Pilih hanya kolom yang dibutuhkan
            ->withCount('pembelianproduks') // Hitung jumlah relasi pembelian produk
            ->orderByDesc('pembelianproduks_count') // Urutkan dari yang terbanyak
            ->take(5) // Ambil 5 produk terlaris
            ->get();

        // 2. Fetch Top 5 Customer berdasarkan jumlah pesanan terbanyak
        $topCustomers = User::select('id', 'name', 'email') // Pilih hanya kolom yang dibutuhkan
            ->withCount(['pembelians as total_pembelian' => function ($query) {
                $query->where('status_pembelian', 'sudah kirim pembayaran'); // Hanya pesanan yang sudah dibayar
            }])
            ->where('role', 'customer') // Filter role user sebagai customer
            ->orderByDesc('total_pembelian') // Urutkan dari jumlah pesanan terbanyak
            ->take(5) // Ambil 5 customer teratas
            ->get();

        // 3. Passing data ke view
        return view('dashboard.index', compact('produkTerlaris', 'topCustomers'));
    }
}
