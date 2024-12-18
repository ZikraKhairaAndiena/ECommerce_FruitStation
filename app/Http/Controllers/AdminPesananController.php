<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPesananController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Mendapatkan query pencarian

        // Query untuk mengambil data dengan pencarian dan pengurutan
        $pesanans = Pembelian::when($search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                // Pencarian berdasarkan nama pengguna (model user terkait)
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                // Pencarian berdasarkan alamat pengiriman
                ->orWhere('alamat_pengiriman', 'like', "%{$search}%");
            });
        })
        ->with('user', 'ongkir') // Memuat relasi user dan ongkir secara eager loading
        ->orderByRaw("FIELD(status_pembelian, 'sudah kirim pembayaran') DESC") // Status 'sudah kirim pembayaran' di urutan pertama
        ->orderByRaw("FIELD(status_pembelian, 'barang dikirim') DESC") // Status 'barang dikirim' di urutan tengah
        ->orderByRaw("FIELD(status_pembelian, 'selesai') ASC") // Status 'selesai' di urutan terakhir
        ->paginate(10); // Paginasi hasilnya

        return view('dashboard.pesanan.index', compact('pesanans'));
    }


    public function show($id)
    {
        $pesanan = Pembelian::with('user', 'ongkir')->findOrFail($id);
        return view('dashboard.pesanan.show', compact('pesanan'));
    }

    public function edit($id)
    {
        $pesanan = Pembelian::findOrFail($id);
        return view('dashboard.pesanan.edit', compact('pesanan'));
    }

    public function update(Request $request, $id)
    {
        // Pastikan pengguna login dan role tersedia
        $user = Auth::user();

        if (!$user || !isset($user->role)) {
            return redirect()->route('dashboard.pesanan.index')->with('error', 'Pengguna tidak memiliki akses.');
        }

        // Temukan data pesanan
        $pesanan = Pembelian::findOrFail($id);

        // Validasi input berdasarkan role
        if ($user->role === 'kurir') {
            $request->validate([
                'status_pembelian' => 'required|string|in:barang dikirim,selesai,batal',
            ]);
            $pesanan->status_pembelian = $request->status_pembelian;
        } elseif ($user->role === 'admin') {
            $request->validate([
                'resi_pengiriman' => 'nullable|string|unique:pembelians,resi_pengiriman,' . $id,
            ], [
                'resi_pengiriman.unique' => 'Resi pengiriman sudah digunakan, harap gunakan resi yang berbeda.',
            ]);
            $pesanan->resi_pengiriman = $request->resi_pengiriman;
        } else {
            return redirect()->route('dashboard.pesanan.index')->with('error', 'Anda tidak memiliki izin untuk melakukan perubahan ini.');
        }

        // Simpan perubahan ke database
        $pesanan->save();

        return redirect()->route('dashboard.pesanan.index')->with('pesan', 'Data pesanan berhasil diperbarui.');
    }

    // Fungsi untuk cetak PDF

    public function cetakPdf(Request $request)
    {
        $query = Pembelian::query();

        // Filter berdasarkan bulan dan tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_pembelian', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pembelian', $request->tahun);
        }

        $pesanans = $query->with('user', 'ongkir')->get();

        $pdf = Pdf::loadView('dashboard.pesanan.cetak_pdf', compact('pesanans'));
        return $pdf->stream('laporan_pesanan.pdf');
    }

}
