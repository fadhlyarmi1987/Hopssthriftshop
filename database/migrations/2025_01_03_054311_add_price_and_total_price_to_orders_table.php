<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->decimal('harga', 10, 2)->after('product_id'); // harga per item
        $table->decimal('total_harga', 10, 2)->after('harga'); // total harga
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('harga');
        $table->dropColumn('total_harga');
    });
}

};
