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
        Schema::table('assets', function (Blueprint $table) {
            $table->integer('code_category')->after('id')->nullable();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('code_region')->after('id')->nullable();
        });
        Schema::table('ruangan', function (Blueprint $table) {
            $table->integer('code_ruangan')->after('id')->nullable();
        });
        Schema::table('rak', function (Blueprint $table) {
            $table->integer('code_rak')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            //
        });
    }
};
