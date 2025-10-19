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

        $provinsiJateng = Provinsi::where('nama', 'Jawa Tengah')->first();
        if ($provinsiJateng) {
            $dataJateng = [
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Banyumas', 'persentase' => 82],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Banjarnegara', 'persentase' => 90],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Batang', 'persentase' => 57],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Blora', 'persentase' => 41],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Boyolali', 'persentase' => 69],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Brebes', 'persentase' => 28],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Cilacap', 'persentase' => 91],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Demak', 'persentase' => 47],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Grobogan', 'persentase' => 60],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Jepara', 'persentase' => 75],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Karanganyar', 'persentase' => 33],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Kebumen', 'persentase' => 54],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Kendal', 'persentase' => 66],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Klaten', 'persentase' => 92],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Kota Magelang', 'persentase' => 36],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Kota Pekalongan', 'persentase' => 70],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Kota Semarang', 'persentase' => 84],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Kota Tegal', 'persentase' => 52],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Kudus', 'persentase' => 45],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Magelang', 'persentase' => 74],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Pati', 'persentase' => 38],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Pekalongan', 'persentase' => 88],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Pemalang', 'persentase' => 56],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Purbalingga', 'persentase' => 62],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Purworejo', 'persentase' => 27],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Rembang', 'persentase' => 49],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Salatiga', 'persentase' => 64],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Semarang', 'persentase' => 80],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Sragen', 'persentase' => 73],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Sukoharjo', 'persentase' => 39],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Surakarta', 'persentase' => 67],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Tegal', 'persentase' => 90],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Temanggung', 'persentase' => 53],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Waduk Kedungombo', 'persentase' => 11],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Wonogiri', 'persentase' => 65],
                ['provinsi_id' => $provinsiJateng->id, 'nama' => 'Wonosobo', 'persentase' => 77],
            ];

            foreach ($dataJateng as $kab) {
                Kabupaten::create($kab);
            }
        }

        $provinsiJatim = Provinsi::where('nama', 'Jawa Timur')->first();
        if ($provinsiJatim) {
            $dataJatim = [
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Bangkalan', 'persentase' => 62],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Banyuwangi', 'persentase' => 88],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Batu', 'persentase' => 47],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Blitar', 'persentase' => 76],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Bojonegoro', 'persentase' => 39],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Bondowoso', 'persentase' => 54],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Gresik', 'persentase' => 68],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Jember', 'persentase' => 91],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Jombang', 'persentase' => 48],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Kediri', 'persentase' => 63],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Kota Blitar', 'persentase' => 72],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Kota Kediri', 'persentase' => 50],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Kota Madiun', 'persentase' => 81],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Kota Malang', 'persentase' => 92],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Kota Mojokerto', 'persentase' => 67],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Kota Pasuruan', 'persentase' => 37],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Kota Probolinggo', 'persentase' => 59],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Lamongan', 'persentase' => 41],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Lumajang', 'persentase' => 73],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Madiun', 'persentase' => 55],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Magetan', 'persentase' => 69],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Malang', 'persentase' => 96],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Mojokerto', 'persentase' => 62],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Nganjuk', 'persentase' => 44],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Ngawi', 'persentase' => 30],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Pacitan', 'persentase' => 47],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Pamekasan', 'persentase' => 51],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Pasuruan', 'persentase' => 64],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Ponorogo', 'persentase' => 72],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Probolinggo', 'persentase' => 36],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Sampang', 'persentase' => 58],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Sidoarjo', 'persentase' => 79],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Situbondo', 'persentase' => 67],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Sumenep', 'persentase' => 45],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Surabaya', 'persentase' => 90],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Trenggalek', 'persentase' => 32],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Tuban', 'persentase' => 61],
                ['provinsi_id' => $provinsiJatim->id, 'nama' => 'Tulungagung', 'persentase' => 84],
            ];
            foreach ($dataJatim as $kab) {
                Kabupaten::create($kab);
            }
        }
    }
}