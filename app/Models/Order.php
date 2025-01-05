<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Order.php

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'address', 'size', 'quantity', 'phone', 'notes', 'product_id', 'status', 'image', 'price', 'total_price'
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
