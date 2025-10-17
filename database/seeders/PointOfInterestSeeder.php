<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PointOfInterest;
use App\Models\Provinsi;

class PointOfInterestSeeder extends Seeder
{
    public function run()
    {
        $provinsiDKI = Provinsi::where('nama', 'DKI Jakarta')->first();

        if ($provinsiDKI) {
            PointOfInterest::create([
                'provinsi_id' => $provinsiDKI->id,
                'nama' => 'INAHEF 2025',
                'alamat' => 'Smesco Indonesia, Jalan Gatot Subroto, Pancoran, Jakarta Selatan',
                'latitude' => -6.2415,
                'longitude' => 106.8373,
            ]);
        }
    }
}