<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Kabupaten;
use App\Models\Hospital;

class HospitalSeeder extends Seeder
{
    public function run()
    {
        $jaksel = Kabupaten::where('nama', 'Jakarta Selatan')->first();
        $semarang = Kabupaten::where('nama', 'Kota Semarang')->first();
        $surabaya = Kabupaten::where('nama', 'Surabaya')->first();

        if ($jaksel) {
            Hospital::create(['kabupaten_id' => $jaksel->id, 'nama_rs' => 'Rumah Sakit A']);
        }
        if ($semarang) {
            Hospital::create(['kabupaten_id' => $semarang->id, 'nama_rs' => 'Rumah Sakit B']);
        }
        if ($surabaya) {
            Hospital::create(['kabupaten_id' => $surabaya->id, 'nama_rs' => 'Rumah Sakit C']);
        }
    }
}