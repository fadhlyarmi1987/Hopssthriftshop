<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    // Jika nama tabel bukan 'orders', Anda dapat menambahkan properti $table
    protected $table = 'orders';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'customer_name',
        'order_date',
        'total_amount',
        'status',
    ];
}
