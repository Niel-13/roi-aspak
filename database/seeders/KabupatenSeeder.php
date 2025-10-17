<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Kabupaten;
use App\Models\Provinsi;
class KabupatenSeeder extends Seeder
{
    public function run()
    {
        $provinsiJakarta = Provinsi::where('nama', 'DKI Jakarta')->first();
        if ($provinsiJakarta) {
            $dataJakarta = [
                ['provinsi_id' => $provinsiJakarta->id, 'nama' => 'Kota Adm. Jakarta Pusat', 'persentase' => 78],
                ['provinsi_id' => $provinsiJakarta->id, 'nama' => 'Kota Adm. Jakarta Barat', 'persentase' => 62],
                ['provinsi_id' => $provinsiJakarta->id, 'nama' => 'Kota Adm. Jakarta Timur', 'persentase' => 85],
                ['provinsi_id' => $provinsiJakarta->id, 'nama' => 'Kota Adm. Jakarta Selatan', 'persentase' => 91],
                ['provinsi_id' => $provinsiJakarta->id, 'nama' => 'Kota Adm. Jakarta Utara', 'persentase' => 73],
            ];
            foreach ($dataJakarta as $kab) {
                Kabupaten::create($kab);
            }
        }
    }
}