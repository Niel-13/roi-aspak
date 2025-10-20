<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Hospital;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Product;

class HospitalLayoutSeeder extends Seeder
{
    public function run()
    {
        // 1. Cari Rumah Sakit A
        $rsA = Hospital::where('nama_rs', 'Rumah Sakit A')->first();
        
        if ($rsA) {
            // 2. Buat Lantai 1 untuk RS A
            $lantai1 = Floor::create([
                'hospital_id' => $rsA->id,
                'nama_lantai' => 'Lantai 1 - Gawat Darurat',
                'gambar_denah' => 'images/denah/rs_a_lt_1.png' // Pastikan Anda punya gambar ini
            ]);

            // 3. Buat Ruangan di Lantai 1
            $ruangUGD = Room::create([
                'floor_id' => $lantai1->id,
                'nama_ruangan' => 'Ruang UGD',
                'posisi_x' => '30%', // 30% dari kiri
                'posisi_y' => '40%'  // 40% dari atas
            ]);
            $ruangOperasi = Room::create([
                'floor_id' => $lantai1->id,
                'nama_ruangan' => 'Ruang Operasi 1',
                'posisi_x' => '65%',
                'posisi_y' => '55%'
            ]);

            // 4. Buat Produk/Alat di Ruang UGD
            Product::create([
                'room_id' => $ruangUGD->id,
                'nama_produk' => 'Defibrillator',
                'gambar_produk' => 'images/produk/defibrillator.png',
                'ketersediaan' => true,
                'link_detail' => 'https://example.com/link-detail-produk-1'
            ]);
            Product::create([
                'room_id' => $ruangUGD->id,
                'nama_produk' => 'Ventilator Portabel',
                'gambar_produk' => 'images/produk/ventilator.png',
                'ketersediaan' => false,
                'link_detail' => 'https://example.com/link-detail-produk-2'
            ]);

            // 5. Buat Produk/Alat di Ruang Operasi
            Product::create([
                'room_id' => $ruangOperasi->id,
                'nama_produk' => 'Meja Operasi C-Arm',
                'gambar_produk' => 'images/produk/meja_operasi.png',
                'ketersediaan' => true,
                'link_detail' => 'https://example.com/link-detail-produk-3'
            ]);

            // 6. Buat Lantai 2 (tanpa ruangan/produk agar simpel)
            Floor::create([
                'hospital_id' => $rsA->id,
                'nama_lantai' => 'Lantai 2 - Rawat Inap',
                'gambar_denah' => 'images/denah/rs_a_lt_2.png'
            ]);
        }
        
        // Ulangi untuk RS B dan RS C jika perlu
    }
}