<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Divisi::create([
            'name' => 'Programmer'
        ]);

        Divisi::create([
            'name' => 'Support'
        ]);

        Divisi::create([
            'name' => 'Manufaktur'
        ]);

        Divisi::create([
            'name' => 'Operational'
        ]);

        Divisi::create([
            'name' => 'GA'
        ]);



    }
}
