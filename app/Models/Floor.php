<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = ['hospital_id', 'nama_lantai', 'gambar_denah'];
    public function hospital() {
        return $this->belongsTo(Hospital::class);
    }
    public function rooms() {
        return $this->hasMany(Room::class);
    }
}
