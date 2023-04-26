<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportProducts implements FromView
{
    use Exportable;
    public function view(): View
    {
        return view('products.ProductsAllExcel', [
            'products' => Product::all()
        ]);
    }
}
