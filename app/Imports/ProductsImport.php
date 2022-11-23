<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Lokasi;
use App\Models\Product;
use Illuminate\Support\Facades\Blade;
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
        $get_category = Category::orderBy('name','ASC')
        ->where('id', $row["category"])->first();
        $lokasi       = Lokasi::orderBy('name','ASC')
        ->where('id',$row["lokasi"])->first();

        $input = strtoupper("Product :".$row['nama'])."\n".strtoupper("Lokasi : ". $row['lokasi_name'])."\n".strtoupper("Category : ".$row['category_name']);
        $qrcode = strtoupper(substr($get_category->name, 0, 1)).strtoupper(substr($get_category->name, 6, 1)).strtoupper(substr($row['nama'], 0, 2)).date('y').date('m').date('d');

       return  $new = new Product([
            'id'            => $row['no'],
            'nama'          => $row['nama'],
            'harga'         => $row['harga'],
            'qty'           => $row['qty'],
            'category_id'   => $row['category'],
            'lokasi_id'     => $row['lokasi'],
            'assets_id'     => $row['assets'],
            'user'          => $row['user'],
            'product_code'  => $input,
            'qrcode'        => $qrcode
        ]);

        // return new Product([
        //     // 'id'            => $row['no'],
        //     // 'nama'          => $row['nama'],
        //     // 'harga'         => $row['harga'],
        //     // 'qty'           => $row['qty'],
        //     // 'category_id'   => $row['category'],
        //     // 'lokasi_id'     => $row['lokasi'],
        //     // 'assets_id'     => $row['assets'],
        //     // 'user'          => $row['user'],
        //     // 'product_code'  => $input,
        // ]);


    }
}
