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
            'name' => "AdminKU",
            'email' => "admin@mail.com",
            'password' => bcrypt("#kuadmiDI"),
        ]);
        User::updateOrCreate(['id' => 2], [
            'name' => "Tri Minarsih",
            'email' => "triminarsih@intek.co.id",
            'password' => bcrypt("tebetinventorysii2022;"),
        ]);
        User::updateOrCreate(['id' => 3], [
            'name' => "Danang",
            'email' => "danang@intek.co.id",
            'password' => bcrypt("cikunirinventorysii2022;"),
        ]);
    }
}
