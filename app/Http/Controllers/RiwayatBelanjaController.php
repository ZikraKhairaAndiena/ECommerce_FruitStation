<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Auth;

class RiwayatBelanjaController extends Controller
{
    public function index()
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = Auth::user();

        // Mengambil riwayat belanja untuk pengguna yang masuk, termasuk produk terkait
        $pembelian = Pembelian::with(['pembelianProduks', 'ulasan'])->where('user_id', $user->id)->get();

        return view('customer.riwayat', compact('user', 'pembelian'));
    }
}
