<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Masuk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImportIn implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $validator = Validator::make($row, [
            'no' => 'required|numeric|max:1000', // Maximum 1000 rows
        ], [
            'no.max' => 'The Rows must not be greater than 1000.'
        ]
        )->validate();
        $date = $row['date'];
        $datestr = Carbon::parse($date);

        return new Product_Masuk([
            'id'            => $row['no'],
            'product_id'   => $row['products'],
            'supplier_id'   => $row['supplier'],
            'qty'           => $row['qty'],
            'tanggal'       => $datestr,
            'keterangan'    => $row['keterangan']
        ]);

    }
}
