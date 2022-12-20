<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportProduk implements FromView
{

    use Exportable;
    public function view(): View
    {
        return view('products.barcode_pdf', [
            'product1' => Product::where('id',$this->id)
        ]);
    }
}
