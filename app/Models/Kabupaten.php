<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $fillable = ['provinsi_id', 'nama', 'persentase'];

    public function pointsOfInterest()
    {
        return $this->hasMany(PointOfInterest::class);
    }
}
