<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;

class OrderController extends Controller
{
    public function history()
    {
        $orders = Pembelian::where('user_id', auth()->id())->get();
        return view('customer.riwayat-belanja', compact('orders'));
    }

    public function makePayment(Request $request, Pembelian $order)
    {
        $validated = $request->validate([
            'nama_penyetor' => 'required|string|max:100',
            'bank' => 'required|string|max:50',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        $payment = $order->pembayarans()->create($validated);

        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('bukti_pembayaran');
            $payment->update(['bukti' => $path]);
        }

        return redirect()->route('orders.history')->with('success', 'Payment submitted!');
    }
}
