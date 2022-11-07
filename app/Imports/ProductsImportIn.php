<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Masuk;
use Carbon\Carbon;
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

        $date = $row['date'];
        $datestr = str_replace(" ' ", "", $date);

        return new Product_Masuk([
            'id'            => $row['no'],
            'product_id'   => $row['products'],
            'supplier_id'   => $row['supplier'],
            'qty'           => $row['qty'],
            'tanggal'       => $datestr
        ]);

    }
}
