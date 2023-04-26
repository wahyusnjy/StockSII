<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    use HasFactory;
    protected $table = 'assets';
    protected $fillable = ['name','parent_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function parent()
    {
        return $this->belongsTo(Assets::class);
    }
}
