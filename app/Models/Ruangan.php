<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $table = 'ruangan';
    protected $fillable = [
        'region_id','name','desc'
    ];

    public function region()
    {
        return $this->belongsTo(Category::class);
    }
}
