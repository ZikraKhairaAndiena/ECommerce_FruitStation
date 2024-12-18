<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pembelian;
use App\Models\PembelianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        // Membuat query dasar untuk mengambil data pembayaran
        $query = Pembayaran::with('pembelian');

        // Jika ada parameter pencarian, tambahkan filter
        if ($request->has('search') && $request->get('search') != '') {
            $search = $request->get('search');

            // Menambahkan pencarian berdasarkan customer, nama penyetor, atau bank
            $query->whereHas('pembelian.user', function($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->orWhere('nama_penyetor', 'like', "%$search%")
            ->orWhere('bank', 'like', "%$search%");
        }

        // Mengambil data pembayaran dengan relasi 'pembelian' dan menambahkan pagination
        $pembayarans = $query->paginate(10);

        // Menghitung total pemasukan
        $total_pemasukan = Pembayaran::sum('jumlah');

        // Mengambil produk terlaris berdasarkan pembelian_produk
        $produkTerlaris = PembelianProduk::select('nama_produk', DB::raw('SUM(jumlah_produk) as jumlah_produk'))
            ->groupBy('nama_produk')
            ->orderByDesc('jumlah_produk')
            ->limit(5)
            ->get();

        // Mengirimkan data ke view
        return view('dashboard.pembayaran.index', compact('pembayarans', 'total_pemasukan', 'produkTerlaris'));
    }


    // Tampilkan formulir pembayaran untuk pembelian tertentu
    public function create($pembelian_id)
    {
        // Menemukan pembelian berdasarkan ID
        $pembelian = Pembelian::findOrFail($pembelian_id);

        // Menampilkan halaman pembayaran
        return view('customer.pembayaran', compact('pembelian'));
    }

    // Menyimpan pembayaran yang diajukan
    public function store(Request $request)
    {
        // Validasi permintaan yang masuk
        $request->validate([
            'pembelian_id' => 'required|exists:pembelians,id',
            'nama_penyetor' => 'required|string|max:100',
            'bank' => 'required|string|max:50',
            'jumlah' => 'required|numeric',
            'bukti' => 'required|file|mimes:jpg,png,jpeg|max:2048', // Maks 2MB
        ]);

        // Tangani unggahan file bukti pembayaran
        if ($request->hasFile('bukti')) {
            $filePath = $request->file('bukti')->store('uploads/bukti', 'public');
        } else {
            return back()->with('error', 'File tidak terunggah');
        }

        // Buat catatan pembayaran baru
        Pembayaran::create([
            'pembelian_id' => $request->pembelian_id,
            'nama_penyetor' => $request->nama_penyetor,
            'bank' => $request->bank,
            'jumlah' => $request->jumlah,
            'tanggal' => now(),
            'bukti' => $filePath,
        ]);

        // Update status pembelian menjadi 'sudah kirim pembayaran'
        $pembelian = Pembelian::find($request->pembelian_id);
        $pembelian->status_pembelian = 'sudah kirim pembayaran'; // Ubah status sesuai kebutuhan
        $pembelian->save();

        return redirect()->route('riwayat.belanja')->with('success', 'Pembayaran berhasil diajukan!');
    }

    // Menampilkan detail pembayaran untuk customer
    public function show($id)
    {
        // Menemukan pembelian berdasarkan ID
        $pembelian = Pembelian::findOrFail($id);

        // Menemukan pembayaran terkait pembelian
        $pembayaran = Pembayaran::where('pembelian_id', $id)->first();

        // Menampilkan halaman lihat pembayaran
        return view('customer.lihat-pembayaran', compact('pembelian', 'pembayaran'));
    }

    // Menampilkan detail pembayaran untuk admin
    public function showAdmin($id)
    {
        // Menemukan pembayaran berdasarkan ID
        $pembayaran = Pembayaran::findOrFail($id);

        // Menampilkan halaman detail pembayaran untuk admin
        return view('dashboard.pembayaran.show', compact('pembayaran'));
    }

    public function cetakPdf(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Filter data berdasarkan bulan dan tahun
        $query = Pembayaran::query();

        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }

        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        $pembayarans = $query->get();

        // Total pemasukan
        $total_pemasukan = $pembayarans->sum('jumlah');

        // Cetak laporan PDF menggunakan dompdf atau library PDF lainnya
        $pdf = \PDF::loadView('dashboard.pembayaran.cetak_pdf', compact('pembayarans', 'total_pemasukan'));
        return $pdf->stream('laporan-pembayaran.pdf');
    }

}
