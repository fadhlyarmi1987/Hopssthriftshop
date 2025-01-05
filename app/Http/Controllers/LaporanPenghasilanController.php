<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanPenghasilanController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel 'orders' dengan status 'done'
        $orders = Laporan::where('status', 'done')->get();

        // Hitung total penghasilan
        $totalPenghasilan = Laporan::where('status', 'done')->sum('total_price');

        // Kirim data ke view 'laporan-penghasilan'
        return view('laporan-penghasilan', compact('orders', 'totalPenghasilan'));
    }
}
