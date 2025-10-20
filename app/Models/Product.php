<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['room_id', 'nama_produk', 'gambar_produk', 'ketersediaan', 'link_detail'];
    public function room() {
        return $this->belongsTo(Room::class);
    }
}
