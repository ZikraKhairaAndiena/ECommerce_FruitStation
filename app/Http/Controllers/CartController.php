<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Promosi;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $this->applyDiscounts(); // Hitung semua diskon
        $cart = session()->get('cart', []);
        $subtotal = session()->get('subtotal', 0); // Ambil subtotal dari sesi
        $discount = session()->get('discount', 0);

        return view('customer.cart', compact('cart', 'subtotal', 'discount'));
    }

    public function add(Request $request)
    {
        $produkId = $request->input('produk_id');
        $produk = Produk::find($produkId);

        if (!$produk) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Periksa stok produk sebelum menambahkannya ke keranjang
        if ($produk->stok_produk < 1) {
            return redirect()->back()->with('error', 'Insufficient stock.');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$produkId])) {
            $cart[$produkId]['quantity']++;
        } else {
            $cart[$produkId] = [
                'id' => $produk->id,
                'name' => $produk->nama_produk,
                'price' => $produk->harga_produk,
                'quantity' => 1,
                'gambar_produk' => $produk->gambar_produk ?? 'default-image.jpg',
            ];
        }

        session()->put('cart', $cart);

        // Kurangi stok produk sebanyak 1
        $produk->stok_produk -= 1;
        $produk->save();

        // Update subtotal in session
        $this->calculateSubtotal();
        $this->applyDiscounts(); // Hitung diskon setelah menambahkan produk

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                $produk = Produk::find($request->id);

                // Hitung perbedaan jumlah untuk menambah atau mengurangi stok
                $difference = $request->quantity - $cart[$request->id]['quantity'];

                // Pastikan stok cukup untuk menambah jumlah
                if ($difference > 0 && $produk->stok_produk < $difference) {
                    return response()->json(['error' => 'Insufficient stock'], 400);
                }

                // Perbarui stok produk
                $produk->stok_produk -= $difference;
                $produk->save();

                $cart[$request->id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);

                // Update subtotal in session
                $this->calculateSubtotal();
                $this->applyDiscounts(); // Hitung diskon setelah memperbarui produk

                return response()->json(['success' => 'Cart updated successfully']);
            }
        }
        return response()->json(['error' => 'Unable to update cart'], 400);
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                // Kembalikan stok produk ketika item dihapus dari keranjang
                $produk = Produk::find($request->id);
                $produk->stok_produk += $cart[$request->id]['quantity'];
                $produk->save();

                unset($cart[$request->id]);
                session()->put('cart', $cart);

                // Update subtotal in session
                $this->calculateSubtotal();
                $this->applyDiscounts(); // Hitung diskon setelah menghapus produk
            }
            return response()->json(['success' => 'Item removed successfully']);
        }
        return response()->json(['error' => 'Unable to remove item'], 400);
    }

    public function applyDiscounts()
    {
        $cart = session('cart', []);
        $totalDiscount = 0;

        // Ambil semua promosi aktif
        $promotions = Promosi::where('active', 1)
                            ->where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                            ->get();

        foreach ($promotions as $promotion) {
            if ($promotion->type === 'quantity_discount') {
                // Diskon kuantitas untuk produk tertentu
                foreach ($cart as $item) {
                    if ($item['id'] == $promotion->produk_id && $item['quantity'] >= $promotion->quantity_required) {
                        $totalDiscount += ($item['price'] * $item['quantity'] * $promotion->discount_percentage) / 100;
                    }
                }
            } elseif ($promotion->type === 'coupon_discount') {
                // Diskon kupon (sudah Anda implementasikan)
                $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
                if ($subtotal >= $promotion->minimum_purchase_amount) {
                    $totalDiscount += ($subtotal * $promotion->discount_percentage) / 100;
                }
            }
        }

        // Simpan diskon total ke sesi
        session(['discount' => $totalDiscount]);

        return response()->json([
            'success' => true,
            'discount' => $totalDiscount,
            'subtotal_after_discount' => array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) - $totalDiscount,
        ]);
    }

    private function calculateSubtotal()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Store the updated subtotal in session
        session()->put('subtotal', $subtotal);
    }
}
