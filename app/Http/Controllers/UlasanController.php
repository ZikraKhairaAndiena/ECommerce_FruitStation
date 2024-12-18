<?php

// UlasanController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Ulasan;

class UlasanController extends Controller
{
    public function create($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        return view('customer.ulasan', compact('pembelian'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:500',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $ulasanData = [
            'pembelian_id' => $id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ];

        if ($request->hasFile('foto')) {
            $fileName = time() . '.' . $request->foto->extension();
            $path = $request->foto->storeAs('public/img', $fileName);

            if ($path) {
                $ulasanData['foto'] = 'img/' . $fileName;  // Menyimpan path relatif
            } else {
                return redirect()->back()->withErrors(['foto' => 'Failed to upload the photo.']);
            }
        }

        Ulasan::create($ulasanData);

        return redirect()->route('riwayat.belanja')->with('success', 'Ulasan berhasil disimpan!');
    }
}

