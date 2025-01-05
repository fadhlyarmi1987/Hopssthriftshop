<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menyimpan data pesanan ke dalam database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'name' => 'required|string',
        'address' => 'required|string',
        'size' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'phone' => 'required|string',
        'notes' => 'nullable|string',
        'product_id' => 'required|exists:products,id',
        'price' => 'required|numeric',  // Pastikan price dan total_price divalidasi
        'total_price' => 'required|numeric',
    ]);
    $product = Product::find($request->product_id);
    $total_price = $request->price * $request->quantity;

    $order = Order::create([
        'name' => $request->name,
        'address' => $request->address,
        'size' => $request->size,
        'quantity' => $request->quantity,
        'phone' => $request->phone,
        'notes' => $request->notes,
        'product_id' => $request->product_id,
        'price' => $request->price,  // Menyimpan harga per item
        'total_price' => $total_price,  // Menyimpan total harga
        'status' => 'waiting',  // Menambahkan field status dengan nilai default 'waiting'
        'image' => $product->image,  // Menambahkan gambar produk dari tabel products
    ]);

    return redirect()->route('products.index')->with('successorder', 'Pesanan berhasil dibuat.');

}




    public function waitingOrders()
    {
        // Mengambil semua pesanan dengan status 'waiting'
        $orders = Order::where('status', 'waiting')->get();

        // Mengirimkan data pesanan ke view transaksi
        return view('transaksi', compact('orders'));
    }

    // Fungsi untuk mengubah status menjadi 'done'
    public function process(Order $order)
    {
        // Cek jika status pesanan masih 'waiting'
        if ($order->status == 'waiting') {
            $order->status = 'done';
            $order->save();
        }

        // Redirect ke halaman detail transaksi atau halaman lain
        return redirect()->route('transaksi')->with('successproses', 'Pesanan telah diproses');
    }

    // Fungsi untuk menghapus pesanan (cancel)
    public function cancel(Order $order)
    {
        // Hapus pesanan dari database
        $order->delete();

        // Redirect ke halaman detail transaksi atau halaman lain
        return redirect()->route('transaksi')->with('success', 'Pesanan telah dibatalkan');
    }
}
