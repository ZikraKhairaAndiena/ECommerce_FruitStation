<?php

namespace App\Http\Controllers;

use App\Models\Promosi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PromosiController extends Controller
{
    // Menampilkan daftar promosi
    public function index(Request $request)
    {
        // Mendapatkan nilai pencarian dari request
        $search = $request->get('search');

        // Mengambil data promosi dengan relasi produk dan menambahkan pencarian
        $promosis = Promosi::with('produk')
            ->when($search, function ($query, $search) {
                // Menambahkan filter pencarian jika ada
                return $query->whereHas('produk', function ($query) use ($search) {
                    // Mencari berdasarkan nama produk
                    $query->where('nama_produk', 'like', '%' . $search . '%');
                })
                ->orWhere('description', 'like', '%' . $search . '%') // Jika ingin mencari deskripsi promosi juga
                ->orWhere('coupon_code', 'like', '%' . $search . '%'); // Atau kode kupon
            })
            ->paginate(10); // Paginate 10 items per page

        // Mengirimkan data ke view
        return view('dashboard.promosi.index', compact('promosis'));
    }


    public function show(Promosi $promosi)
    {
        return view('dashboard.promosi.show', compact('promosi'));
    }

    // Menampilkan form tambah promosi
    public function create()
    {
        $produks = Produk::all(); // Mendapatkan semua produk
        return view('dashboard.promosi.create', compact('produks'));
    }

    // Menyimpan data promosi baru
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'produk_id' => 'nullable|exists:produks,id',
            'type' => 'required|in:coupon,quantity_discount',
            'description' => 'required|string|max:255',
            'quantity_required' => 'nullable|integer|min:1',
            'minimum_purchase_amount' => 'nullable|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'coupon_code' => 'nullable|string|max:50|unique:promosis,coupon_code',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'required|boolean',
        ]);

        // Logika khusus untuk tipe kupon
        if ($validatedData['type'] === 'coupon') {
            $validatedData['applies_to_all'] = true; // Kupon berlaku untuk semua produk
            $validatedData['produk_id'] = null; // produk_id harus null
        } else {
            $validatedData['applies_to_all'] = false; // Tidak berlaku untuk semua produk
        }

        // Simpan data ke database
        Promosi::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect('/promosi')->with('pesan', 'Promosi berhasil ditambahkan!');
    }

    // Menampilkan form edit promosi
    public function edit($id)
    {
        $promosi = Promosi::findOrFail($id);
        $produks = Produk::all(); // Mendapatkan semua produk
        return view('dashboard.promosi.edit', compact('promosi', 'produks'));
    }

    // Memperbarui data promosi
    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'produk_id' => 'nullable|exists:produks,id',
            'type' => 'required|in:coupon,quantity_discount',
            'description' => 'required|string|max:255',
            'quantity_required' => 'nullable|integer|min:1',
            'minimum_purchase_amount' => 'nullable|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'coupon_code' => 'nullable|string|max:50|unique:promosis,coupon_code,' . $id,
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'required|boolean',
        ]);

        // Logika khusus untuk tipe kupon
        if ($validatedData['type'] === 'coupon') {
            $validatedData['applies_to_all'] = true; // Kupon berlaku untuk semua produk
            $validatedData['produk_id'] = null; // produk_id harus null
        } else {
            $validatedData['applies_to_all'] = false; // Tidak berlaku untuk semua produk
        }

        // Update data di database
        $promosi = Promosi::findOrFail($id);
        $promosi->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect('/promosi')->with('pesan', 'Promosi berhasil diperbarui!');
    }

    // Menghapus data promosi
    public function destroy($id)
    {
        $promosi = Promosi::findOrFail($id);
        $promosi->delete();

        return redirect('/promosi')->with('pesan', 'Promosi berhasil dihapus!');
    }

    public function cetakPdf()
    {
        $promosis = Promosi::with('produk')->get();
        $pdf = Pdf::loadView('dashboard.promosi.cetak_pdf', compact('promosis'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-promosi.pdf');
    }
}
