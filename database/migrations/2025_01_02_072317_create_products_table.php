<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama produk
            $table->string('category'); // Kategori produk
            $table->decimal('price', 10, 2); // Harga produk
            $table->text('description')->nullable(); // Deskripsi produk (opsional)
            $table->string('image_path')->nullable(); // Lokasi gambar produk (opsional)
            $table->timestamps(); // Kolom waktu untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
