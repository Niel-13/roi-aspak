<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provinsi;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // ['nama' => 'Aceh', 'persentase' => 85],
            // ['nama' => 'Sumatera Utara', 'persentase' => 65],
            // ['nama' => 'Sumatera Barat', 'persentase' => 45],
            // ['nama' => 'Riau', 'persentase' => 25],
            // ['nama' => 'Jambi', 'persentase' => 5],
            // ['nama' => 'Sumatera Selatan', 'persentase' => 90],
            // ['nama' => 'Bengkulu', 'persentase' => 70],
            // ['nama' => 'Lampung', 'persentase' => 50],
            // ['nama' => 'Bangka Belitung', 'persentase' => 30],
            // ['nama' => 'Kepulauan Riau', 'persentase' => 10],
            ['nama' => 'DKI Jakarta', 'persentase' => 95],
            // ['nama' => 'Jawa Barat', 'persentase' => 75],
            ['nama' => 'Jawa Tengah', 'persentase' => 55],
            // ['nama' => 'DKI Yogyakarta', 'persentase' => 35],
            ['nama' => 'Jawa Timur', 'persentase' => 80],
            // ['nama' => 'Banten', 'persentase' => 80],
            // ['nama' => 'Bali', 'persentase' => 60],
            // ['nama' => 'Nusa Tenggara Barat', 'persentase' => 40],
            // ['nama' => 'Nusa Tenggara Timur', 'persentase' => 20],
            // ['nama' => 'Kalimantan Barat', 'persentase' => 90],
            // ['nama' => 'Kalimantan Tengah', 'persentase' => 70],
            // ['nama' => 'Kalimantan Selatan', 'persentase' => 50],
            // ['nama' => 'Kalimantan Timur', 'persentase' => 30],
            // ['nama' => 'Kalimantan Utara', 'persentase' => 10],
            // ['nama' => 'Sulawesi Utara', 'persentase' => 95],
            // ['nama' => 'Gorontalo', 'persentase' => 75],
            // ['nama' => 'Sulawesi Tengah', 'persentase' => 55],
            // ['nama' => 'Sulawesi Barat', 'persentase' => 35],
            // ['nama' => 'Sulawesi Selatan', 'persentase' => 15],
            // ['nama' => 'Sulawesi Tenggara', 'persentase' => 80],
            // ['nama' => 'Maluku', 'persentase' => 60],
            // ['nama' => 'Maluku Utara', 'persentase' => 40],
            // ['nama' => 'Papua Barat', 'persentase' => 20],
            // ['nama' => 'Papua', 'persentase' => 85],
        ];

        foreach ($data as $item) {
            Provinsi::create($item);
        }
    }
}