<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = ['kabupaten_id', 'nama_rs'];
    public function kabupaten() {
    return $this->belongsTo(Kabupaten::class);
}
}
