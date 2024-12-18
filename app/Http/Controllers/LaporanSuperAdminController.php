<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pembayaran;
use App\Models\TransaksiPemasok;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanSuperAdminController extends Controller
{
    // Method to generate the Pesanan report with filtering by month and year
    public function cetakPesanan(Request $request)
    {
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        // Query the Pembelian model and apply the filters
        $pesanans = Pembelian::query();

        if ($bulan) {
            $pesanans = $pesanans->whereMonth('tanggal_pembelian', $bulan);
        }

        if ($tahun) {
            $pesanans = $pesanans->whereYear('tanggal_pembelian', $tahun);
        }

        $pesanans = $pesanans->get();

        // Generate PDF
        $pdf = Pdf::loadView('dashboard.laporan.pesanan', compact('pesanans', 'bulan', 'tahun'));
        return $pdf->stream('laporan-pesanan.pdf');
    }

    // Method to generate the Pembayaran report with filtering by month and year
    public function cetakPembayaran(Request $request)
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
        // Generate PDF
        $pdf = Pdf::loadView('dashboard.laporan.pembayaran', compact('pembayarans', 'total_pemasukan', 'bulan', 'tahun'));
        return $pdf->stream('laporan-pembayaran.pdf');
    }

    // Method to generate the Transaksi Pemasok report with filtering by month and year
    public function cetakTransaksiPemasok(Request $request)
    {
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        // Query the TransaksiPemasok model and apply the filters
        $transaksis = TransaksiPemasok::with('pemasok', 'produk');

        if ($bulan) {
            $transaksis = $transaksis->whereMonth('tanggal_transaksi', $bulan);
        }

        if ($tahun) {
            $transaksis = $transaksis->whereYear('tanggal_transaksi', $tahun);
        }

        $transaksis = $transaksis->get();

        // Generate PDF
        $pdf = Pdf::loadView('dashboard.laporan.transaksi_pemasok', compact('transaksis', 'bulan', 'tahun'));
        return $pdf->stream('laporan-transaksi-pemasok.pdf');
    }
}
