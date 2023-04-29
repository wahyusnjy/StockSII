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
            $table->integer('region_id')->after('divisi_id')->nullable();
            $table->integer('room_id')->after('region_id')->nullable();
            $table->integer('rack_id')->after('room_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_out', function (Blueprint $table) {
            //
        });
    }
};
