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

        $input = $row['no'];
        $code = $row['nama'];
        $get_category = Category::orderBy('name','ASC')->first();
        //dd($get_category);
        $input = strtoupper(substr($get_category->name, 0, 3)).strtoupper(substr($code, 0,2)).strtoupper(substr($input, 0)).date('Y').date('m').date('d').strtotime("now");

        return new Product([
            'id'            => $row['no'],
            'nama'          => $row['nama'],
            'harga'         => $row['harga'],
            'qty'           => $row['qty'],
            'category_id'   => $row['category'],
            'lokasi_id'     => $row['lokasi'],
            'assets_id'     => $row['assets'],
            'product_code'  => $input
        ]);

    }
}
