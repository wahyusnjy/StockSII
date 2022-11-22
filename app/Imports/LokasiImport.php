<?php

namespace App\Imports;

use App\Models\Lokasi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LokasiImport implements  ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Lokasi([
            'id'            => $row['no'],
            'name'          => $row['lokasi'],
        ]);
    }
}
