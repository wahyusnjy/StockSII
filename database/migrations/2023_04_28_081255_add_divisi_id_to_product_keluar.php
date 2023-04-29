<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_keluar', function (Blueprint $table) {
            $table->integer('divisi_id')->after('customer_id')->nullable();
            $table->string('nama_peminjam')->after('divisi_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_keluar', function (Blueprint $table) {
            //
        });
    }
};
