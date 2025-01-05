<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('size');
            $table->integer('quantity');
            $table->string('phone');
            $table->string('image')->nullable()->change();
            $table->text('notes')->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Menghubungkan ke tabel produk
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
