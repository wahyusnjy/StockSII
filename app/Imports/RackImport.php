<?php

namespace App\Imports;

use App\Models\Rak;
use App\Models\Ruangan;
use Cloudinary\Transformation\Region;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RackImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {

        $room = Ruangan::where('name','like','%' . $row['room'] . '%')->get();
        foreach($room as $r){

            return new Rak([
                'room_id'       => $r->id,
                'name'          => $row['rak'],
                'desc'          => $row['desc'],
            ]);
        }
        // dd($room->id);


    }
}
