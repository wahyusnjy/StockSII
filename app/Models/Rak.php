<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;
    protected $table = 'rak';
    protected $fillable = ['room_id','name','desc'];

    public function room()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
