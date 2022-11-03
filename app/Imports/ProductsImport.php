<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $get_category = Category::orderBy('name','ASC')->first();
        $input = strtoupper(substr($get_category->name, 0, 1)).strtoupper(substr($get_category->name, 1, 2)).date('Y').date('m').date('d').strtotime("now");
        return new Product([

            'nama'          => $row['nama'],
            'harga'         => $row['harga'],
            'qty'           => $row['qty'],
            'category_id'   => $row['category'],
            'product_code'  => $input
        ]);
    }
}
