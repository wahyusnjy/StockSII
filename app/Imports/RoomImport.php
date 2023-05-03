<?php

namespace App\Imports;

use App\Models\Ruangan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RoomImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        if($row['region'] == 'TB1'){
            $region = 1;
        } elseif($row['region'] == 'CI1'){
            $region = 2;
        } elseif($row['region'] == 'CI2'){
            $region = 3;
        } elseif($row['region'] == 'CI3'){
            $region = 4;
        }

        return new Ruangan([
            'region_id'     => $region,
            'name'          => $row['lokasi'],
            'desc'          => $row['desc'],
        ]);
    }
}
