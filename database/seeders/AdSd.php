<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdSd extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(['id' => 1], [
            'name' => "Admin",
            'email' => "admin@admin.com",
            'password' => bcrypt("password"),
            'role'  => "admin",
        ]);
        User::updateOrCreate(['id' => 2], [
            'name' => "Tri Minarsih",
            'email' => "triminarsih@intek.co.id",
            'password' => bcrypt("tebetinventorysii2022;"),
            'role'  => "staff",
        ]);
        User::updateOrCreate(['id' => 3], [
            'name' => "Eko Prasetyo",
            'email' => "eko@intek.co.id",
            'password' => bcrypt("password;"),
            'role'  => "staff",
        ]);
    }
}
