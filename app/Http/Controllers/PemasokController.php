<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PemasokController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan nilai pencarian dari request
        $search = $request->get('search');

        // Mengambil data pemasok dengan pencarian jika ada
        $pemasoks = Pemasok::when($search, function ($query, $search) {
            // Menambahkan filter pencarian berdasarkan nama, alamat, atau telepon
            return $query->where('nama_pemasok', 'like', '%' . $search . '%')
                ->orWhere('alamat', 'like', '%' . $search . '%')
                ->orWhere('no_telepon', 'like', '%' . $search . '%');
        })
        ->paginate(10); // Pagination 10 item per halaman

        return view('dashboard.pemasok.index', compact('pemasoks'));
    }


    public function create()
    {
        return view('dashboard.pemasok.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemasok' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'no_rekening' => 'required|string|max:30',
            'alamat' => 'required|string',
        ]);

        Pemasok::create($request->all());
        return redirect()->route('dashboard.pemasok.index')->with('success', 'Pemasok berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pemasok = Pemasok::findOrFail($id);
        return view('dashboard.pemasok.show', compact('pemasok'));
    }

    public function edit($id)
    {
        $pemasok = Pemasok::findOrFail($id); // Fetch the pemasok by ID
        return view('dashboard.pemasok.edit', compact('pemasok'));
    }

    public function update(Request $request, $id)
    {
        $pemasok = Pemasok::findOrFail($id); // Fetch the pemasok by ID

        $request->validate([
            'nama_pemasok' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'no_rekening' => 'required|string|max:30',
            'alamat' => 'required|string',
        ]);

        $pemasok->update($request->all());
        return redirect()->route('dashboard.pemasok.index')->with('success', 'Pemasok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pemasok = Pemasok::findOrFail($id); // Fetch the pemasok by ID
        $pemasok->delete();
        return redirect()->route('dashboard.pemasok.index')->with('success', 'Pemasok berhasil dihapus.');
    }

    public function cetakPdf()
    {
        $pemasoks = Pemasok::all();
        $pdf = Pdf::loadView('dashboard.pemasok.cetak_pdf', compact('pemasoks'));

        return $pdf->stream('daftar_pemasok.pdf');
    }
}
