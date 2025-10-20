<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['floor_id', 'nama_ruangan', 'posisi_x', 'posisi_y'];
    public function floor() {
        return $this->belongsTo(Floor::class);
    }
    public function products() {
        return $this->hasMany(Product::class);
    }
}
