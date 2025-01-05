<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToOrdersTable extends Migration
{
    /**
     * Menambahkan kolom image ke tabel orders.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom image yang bisa null
            $table->string('image')->nullable()->after('status');
        });
    }

    /**
     * Mengembalikan perubahan yang dilakukan pada migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menghapus kolom image
            $table->dropColumn('image');
        });
    }
}
