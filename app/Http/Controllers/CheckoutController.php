<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PembelianProduk;
use App\Models\Ongkir;

class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        $cartItems = session()->get('cart', []); // Mengambil keranjang dari session
        $subtotal = session()->get('subtotal', 0);
        $discount = session()->get('discount', 0);
        $ongkir_tarif = session()->get('ongkir_tarif', 0); // Default ongkir adalah 0
        $total = $subtotal - $discount + $ongkir_tarif; // Total setelah diskon dan ongkir

        $ongkirs = Ongkir::all();

        // Pastikan variabel yang digunakan di view sesuai
        return view('customer.checkout', compact('cartItems', 'subtotal', 'discount', 'total', 'ongkirs', 'ongkir_tarif'));
    }

    public function process(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'alamat_pengiriman' => 'required|string|max:255',
            'ongkir_id' => 'required|exists:ongkirs,id',
        ]);

        // Ambil subtotal, diskon, dan ongkir dari session
        $subtotal = session('subtotal', 0);
        $discount = session('discount', 0);
        $ongkir = Ongkir::find($request->ongkir_id);

        // Pastikan ongkir ditemukan
        if (!$ongkir) {
            return redirect()->back()->withErrors(['ongkir' => 'Ongkir tidak ditemukan.']);
        }

        // Hitung total pembelian
        $total_pembelian = ($subtotal - $discount) + $ongkir->tarif;

        // Buat record Pembelian baru
        $pembelian = Pembelian::create([
            'user_id' => auth()->id(),
            'ongkir_id' => $ongkir->id,
            'tanggal_pembelian' => now(),
            'total_pembelian' => $total_pembelian,
            'discount' => $discount,
            'nama_kota' => $ongkir->nama_kota,
            'tarif' => $ongkir->tarif,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'status_pembelian' => 'pending',
        ]);

        // Simpan produk yang ada di keranjang ke tabel pembelian_produks
        foreach (session('cart', []) as $item) {
            PembelianProduk::create([
                'pembelian_id' => $pembelian->id,
                'produk_id' => $item['id'],
                'nama_produk' => $item['name'],
                'jumlah_produk' => $item['quantity'],
                'harga_produk' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price'],
            ]);
        }

        // Hapus data dari session setelah checkout
        session()->forget(['cart', 'subtotal', 'discount', 'ongkir_tarif']);

        // Redirect ke halaman nota
        return redirect()->route('nota', ['id' => $pembelian->id]);
    }

    public function nota($id)
    {
        // Ambil data pembelian berdasarkan ID
        $pembelian = Pembelian::with('ongkir', 'pembelianProduk')->findOrFail($id);

        // Kembalikan view dengan data pembelian
        return view('customer.nota', compact('pembelian'));
    }
}
