<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Lokasi;
use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{

    private $rows = 0;

    public function model(array $row)
    {
        ++$this->rows;


        $validator = Validator::make($row, [
            'no' => 'required|numeric|max:1000', // Maximum 1000 rows
        ], [
            'no.max' => 'The Rows must not be greater than 1000.'
        ]
        )->validate();

        $input = $row['no'];
        $code = $row['nama'];
        $get_category = Category::orderBy('name','ASC')
        ->where('id', $row["region"])->first();
        //  dd($get_category);
        $lokasi       = Lokasi::orderBy('name','ASC')
        ->where('id',$row["lokasi"])->first();
        $productname = Product::where('nama', $row['nama'])->first();
        //dd($row['category_name']);

        $input = strtoupper("Product :".$row['nama'])."\n".strtoupper("Lokasi : ". $row['lokasi_name']).    $row['user'];
        $prefix = '.';
        $id = $row['no'];
        $test = str_pad($id,5,'0', STR_PAD_LEFT);
        $qrcode = strtoupper(substr($row['category_name'] , 0, 1).substr($row['category_name'], 6, 1)).$test;
        $productqty = Product::first();
        if(empty($productqty->qty)){
            $newqty = $row['qty'];
        }else{
            $newqty = $productqty->qty + $row['qty'];
        }

        return  $new = Product::updateOrCreate(
            [
            'nama' => $row['nama'] ?? $productname->nama ?? 'Not Found',
            'category_id'   => $row['region'] ?? 0,
            'assets_id'     => $row['category'] ?? 0,
            'lokasi_id'     => $row['lokasi'] ?? 0,
            'product_code'  => $input ?? '404 Not Found',
            'qrcode'        => $qrcode ?? '404 Not Found',
            'divisi_id'     => Auth::user()->divisi_id,
            'user_id'       => Auth::user()->id,
            ],[

                'id'            => $row['no'] ?? 0,
                'qty'           => $newqty ?? $row['qty'] ?? 0,
                'harga'         => $row['harga'] ?? 0,
                'user'          => $row['user'] ?? 'Tidak Ditemukan',
            ]);
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
        return [
            'id' => 'numeric|min:1|max:4'
        ];
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
