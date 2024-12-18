<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil nilai pencarian dari query string
        $search = $request->get('search');

        // Jika ada pencarian, filter kategori berdasarkan nama_kategori
        $kategoris = Kategori::when($search, function ($query, $search) {
            return $query->where('nama_kategori', 'like', "%{$search}%");
        })->latest()->paginate(10);  // Tetap menggunakan paginasi dengan 10 data per halaman

        // Mengirim data ke view
        return view('dashboard.kategori.index', ['kategoris' => $kategoris]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('dashboard.kategori.create', ['kategoris'=>$kategoris]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request-> validate([
            'nama_kategori' => 'required|min:3',
        ]);

        // dd($validated);
        Kategori::create($validated);
        return redirect('/kategori');

        // dd($validated);
        Kategori::create($validated);
        return redirect('/kategori');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('dashboard.kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id); // Ambil satu instance model berdasarkan id
        return view('dashboard.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|min:3',
        ]);

        Kategori::where('id', $id)->update($validated);
        return redirect('kategori')->with('pesan', 'Data berhasil diubah');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Kategori::destroy($id);
        return redirect('kategori')->with('pesan','Data berhasil dihapus');
    }
}
