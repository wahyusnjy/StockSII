<?php

namespace App\Exports;

use App\Models\Lokasi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;


class ExportLokasi implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('lokasi.lokasiAllExcel',[
            'lokasi' => Lokasi::all()
        ]);
    }
}
