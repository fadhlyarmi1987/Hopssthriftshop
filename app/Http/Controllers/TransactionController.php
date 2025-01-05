<?php

// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function history()
    {
        // Ambil semua pesanan dengan status 'done'
        $orders = Order::where('status', 'done')->get();

        // Kirim data ke view
        return view('riwayat.transaksi', compact('orders'));
    }
}
