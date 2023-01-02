<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Keluar;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImportOut implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $date = $row['date'];
        $datestr = str_replace(" - ", "", $date);

        return new Product_Keluar([
            'id'            => $row['no'],
            'product_id'   => $row['products'],
            'customer_id'   => $row['customer'],
            'qty'           => $row['qty'],
            'tanggal'       => $datestr,
            'keterangan'    => $row['keterangan']
        ]);

    }
}
