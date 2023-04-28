<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['category_id','lokasi_id','assets_id','nama','harga','image','qty','link','product_code','user','qrcode','user_id','divisi_id','rack_id','room_id'];

    protected $hidden = ['created_at','updated_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function assets()
    {
        return $this->belongsTo(Assets::class);
    }

    public function rack()
    {
        return $this->belongsTo(Rak::class);
    }

    public function room()
    {
        return $this->belongsTo(Ruangan::class);
    }
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}
