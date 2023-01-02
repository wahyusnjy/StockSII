<?php

namespace App\Imports;

use App\Models\Lokasi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LokasiImport implements  ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'no' => 'required|numeric|max:1000', // Maximum 1000 rows
        ], [
            'no.max' => 'The Rows must not be greater than 1000.'
        ]
        )->validate();
        return new Lokasi([
            'id'            => $row['no'],
            'name'          => $row['lokasi'],
        ]);
    }
}
