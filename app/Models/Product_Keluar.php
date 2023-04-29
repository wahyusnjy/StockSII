<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Keluar extends Model
{
    protected $table = 'product_keluar';

    protected $fillable = ['product_id','customer_id','qty','tanggal','keterangan','divisi_id','nama_peminjam','region_id','room_id','rack_id'];

    protected $hidden = ['created_at','updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function region()
    {
        return $this->belongsTo(Category::class);
    }

    public function room()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function rack()
    {
        return $this->belongsTo(Rak::class);
    }
}
