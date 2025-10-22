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
        $rsA = Hospital::where('nama_rs', 'RS INAHEF')->first();

        if ($rsA) {
            $lantai1_rsA = Floor::create([
                'hospital_id' => $rsA->id,
                'nama_lantai' => 'Lantai 1',
                'gambar_denah' => 'rs_a_lt_1.svg'
            ]);
            
            $this->createRoomsForFloor($lantai1_rsA->id);

            $lantai2_rsA = Floor::create([
                'hospital_id' => $rsA->id,
                'nama_lantai' => 'Lantai 2',
                'gambar_denah' => 'rs_a_lt_2.svg'
            ]);

            $this->createRoomsForFloor($lantai2_rsA->id);
        }

        $rsB = Hospital::where('nama_rs', 'Rumah Sakit B')->first();
        
        if ($rsB) {

            $lantai3_rsB = Floor::create([
                'hospital_id' => $rsB->id,
                'nama_lantai' => 'Lantai 3',
                'gambar_denah' => 'rs_b_lt_3.svg'
            ]);

            $this->createRoomsForFloor($lantai3_rsB->id);
        }

        $rsC = Hospital::where('nama_rs', 'Rumah Sakit C')->first();

        if ($rsC) {
            $lantai3_rsC = Floor::create([
                'hospital_id' => $rsC->id,
                'nama_lantai' => 'Lantai 3',
                'gambar_denah' => 'rs_c_lt_3.svg'
            ]);

            $this->createRoomsForFloor($lantai3_rsC->id);
        }
    }

    private function createRoomsForFloor($floorId)
    {
        $roomsData = [
            ['nama' => 'LOBBY', 'kode_svg' => 'lobby-1', 'persentase' => 45],
            ['nama' => 'IGD', 'kode_svg' => 'igd', 'persentase' => 65],
            ['nama' => 'LOBBY', 'kode_svg' => 'lobby-2', 'persentase' => 45],
            ['nama' => 'FARMASI SATELIT', 'kode_svg' => 'farmasi-satelit', 'persentase' => 65],
            ['nama' => 'RAJAL', 'kode_svg' => 'rajal', 'persentase' => 65],
            ['nama' => 'LAB', 'kode_svg' => 'lab', 'persentase' => 65],
            ['nama' => 'RADIOLOGI', 'kode_svg' => 'radiologi', 'persentase' => 65],
            ['nama' => 'RANAP', 'kode_svg' => 'ranap-1', 'persentase' => 65],
            ['nama' => 'HD & BANK DARAH', 'kode_svg' => 'hd-bank-darah', 'persentase' => 65],
            ['nama' => 'REHAB MEDIK', 'kode_svg' => 'rehab-medik', 'persentase' => 65],
            ['nama' => 'ICU', 'kode_svg' => 'icu', 'persentase' => 65],
            ['nama' => 'RANAP', 'kode_svg' => 'ranap-2', 'persentase' => 65],
            ['nama' => 'RADIOTERAPI', 'kode_svg' => 'radioterapi', 'persentase' => 65],
            ['nama' => 'OK', 'kode_svg' => 'ok', 'persentase' => 65],
            ['nama' => 'PERSALINAN', 'kode_svg' => 'persalinan', 'persentase' => 65],
            ['nama' => 'RANAP', 'kode_svg' => 'ranap-3', 'persentase' => 65],
            ['nama' => 'MEKANIK', 'kode_svg' => 'mekanik', 'persentase' => 25], 
            ['nama' => 'GIZI', 'kode_svg' => 'gizi', 'persentase' => 25],
            ['nama' => 'LAUNDRY', 'kode_svg' => 'laundry', 'persentase' => 25],
            ['nama' => 'CSSD', 'kode_svg' => 'cssd', 'persentase' => 25],
            ['nama' => 'R. FORENSIK & JENAZAH', 'kode_svg' => 'r-forensik-jenazah', 'persentase' => 65],
            ['nama' => 'FARMASI SENTRAL', 'kode_svg' => 'farmasi-sentral', 'persentase' => 65],
            ['nama' => 'SCHNEIDER', 'kode_svg' => 'schneider', 'persentase' => 70],
            ['nama' => 'ITS', 'kode_svg' => 'its', 'persentase' => 74]
        ];

        foreach ($roomsData as $room) {
        $newRoom = Room::create([
            'floor_id' => $floorId,
            'nama_ruangan' => $room['nama'],
            'kode_svg' => $room['kode_svg'],
            'persentase' => $room['persentase']
        ]);

        switch ($room['kode_svg']) {
            case 'igd':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Patient Monitor', 'gambar_produk' => 'images/produk/patient_monitor.png', 'persentase' => 80, 'link_detail' => 'https://app.aspak-kemenkes.cloud/bmsdashboard'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Electronic Baby Scale', 'gambar_produk' => 'images/produk/baby_scale.png', 'persentase' => 65,'link_detail' => 'https://example.com/link-detail-produk-2'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Timbangan (SECA)', 'gambar_produk' => 'images/produk/seca.png', 'persentase' => 30, 'link_detail' => 'https://app.aspak-kemenkes.cloud/dashseca']
                ]);
                break;

            case 'icu':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Patient Monitor', 'gambar_produk' => 'images/produk/patient_monitor.png', 'persentase' => 80, 'link_detail' => 'https://app.aspak-kemenkes.cloud/bmsdashboard'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Infusion Pump', 'gambar_produk' => 'images/produk/infusion_pump.png', 'persentase' => 85, 'link_detail' => 'https://example.com/infusion-pump'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Suction Machine', 'gambar_produk' => 'images/produk/suction_machine.png', 'persentase' => 75, 'link_detail' => 'https://example.com/suction-machine']
                ]);
                break;

            case 'ok':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Patient Monitor', 'gambar_produk' => 'images/produk/patient_monitor.png', 'persentase' => 80, 'link_detail' => 'https://app.aspak-kemenkes.cloud/bmsdashboard'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Surgical Lamp', 'gambar_produk' => 'images/produk/surgical_lamp.png', 'persentase' => 85, 'link_detail' => 'https://example.com/surgical-lamp'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Anesthesia Machine', 'gambar_produk' => 'images/produk/anesthesia_machine.png', 'persentase' => 90, 'link_detail' => 'https://example.com/anesthesia-machine']
                ]);
                break;

            case 'lab':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Centrifuge', 'gambar_produk' => 'images/produk/centrifuge.png', 'persentase' => 75, 'link_detail' => 'https://example.com/centrifuge'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Microscope', 'gambar_produk' => 'images/produk/microscope.png', 'persentase' => 85, 'link_detail' => 'https://example.com/microscope'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Blood Analyzer', 'gambar_produk' => 'images/produk/blood_analyzer.png', 'persentase' => 90, 'link_detail' => 'https://example.com/blood-analyzer']
                ]);
                break;

            case 'radiologi':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'X-Ray Machine', 'gambar_produk' => 'images/produk/xray_machine.png', 'persentase' => 80, 'link_detail' => 'https://example.com/xray'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'CT Scan', 'gambar_produk' => 'images/produk/ct_scan.png', 'persentase' => 85, 'link_detail' => 'https://example.com/ct-scan'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Ultrasound', 'gambar_produk' => 'images/produk/ultrasound.png', 'persentase' => 75, 'link_detail' => 'https://example.com/ultrasound']
                ]);
                break;

            case 'rehab-medik':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Treadmill Terapi', 'gambar_produk' => 'images/produk/treadmill.png', 'persentase' => 85, 'link_detail' => 'https://example.com/rehab-treadmill'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Ultrasound Therapy Unit', 'gambar_produk' => 'images/produk/ultrasound_therapy.png', 'persentase' => 75, 'link_detail' => 'https://example.com/ultrasound-therapy'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Parallel Bar', 'gambar_produk' => 'images/produk/parallel_bar.png', 'persentase' => 65, 'link_detail' => 'https://example.com/parallel-bar']
                ]);
                break;

            case 'radioterapi':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Linear Accelerator', 'gambar_produk' => 'images/produk/linear_accelerator.png', 'persentase' => 80, 'link_detail' => 'https://example.com/linear-accelerator'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Radiation Shield', 'gambar_produk' => 'images/produk/radiation_shield.png', 'persentase' => 70, 'link_detail' => 'https://example.com/radiation-shield'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Dosimeter', 'gambar_produk' => 'images/produk/dosimeter.png', 'persentase' => 65, 'link_detail' => 'https://example.com/dosimeter']
                ]);
                break;

            case 'persalinan':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Patient Monitor', 'gambar_produk' => 'images/produk/patient_monitor.png', 'persentase' => 80, 'link_detail' => 'https://app.aspak-kemenkes.cloud/bmsdashboard'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Infant Warmer', 'gambar_produk' => 'images/produk/infant_warmer.png', 'persentase' => 75, 'link_detail' => 'https://example.com/infant-warmer'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Timbangan (SECA)', 'gambar_produk' => 'images/produk/seca.png', 'persentase' => 30, 'link_detail' => 'https://app.aspak-kemenkes.cloud/dashseca']                
                ]);
                break;

            case 'ranap-1':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Hospital Bed', 'gambar_produk' => 'images/produk/hospital_bed.png', 'persentase' => 85, 'link_detail' => 'https://example.com/hospital-bed'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Overbed Table', 'gambar_produk' => 'images/produk/overbed_table.png', 'persentase' => 70, 'link_detail' => 'https://example.com/overbed-table'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Infusion Stand', 'gambar_produk' => 'images/produk/infusion_stand.png', 'persentase' => 80, 'link_detail' => 'https://example.com/infusion-stand']
                ]);
                break;

            case 'ranap-2':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Hospital Bed', 'gambar_produk' => 'images/produk/hospital_bed.png', 'persentase' => 85, 'link_detail' => 'https://example.com/hospital-bed'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Overbed Table', 'gambar_produk' => 'images/produk/overbed_table.png', 'persentase' => 70, 'link_detail' => 'https://example.com/overbed-table'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Infusion Stand', 'gambar_produk' => 'images/produk/infusion_stand.png', 'persentase' => 80, 'link_detail' => 'https://example.com/infusion-stand']
                ]);
                break;
            
            case 'ranap-3':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Hospital Bed', 'gambar_produk' => 'images/produk/hospital_bed.png', 'persentase' => 85, 'link_detail' => 'https://example.com/hospital-bed'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Overbed Table', 'gambar_produk' => 'images/produk/overbed_table.png', 'persentase' => 70, 'link_detail' => 'https://example.com/overbed-table'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Infusion Stand', 'gambar_produk' => 'images/produk/infusion_stand.png', 'persentase' => 80, 'link_detail' => 'https://example.com/infusion-stand']
                ]);
                break;

            case 'rajal':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Timbangan (SECA)', 'gambar_produk' => 'images/produk/seca.png', 'persentase' => 30, 'link_detail' => 'https://app.aspak-kemenkes.cloud/dashseca'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Stethoscope', 'gambar_produk' => 'images/produk/stethoscope.png', 'persentase' => 85, 'link_detail' => 'https://example.com/stethoscope'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'BP Apparatus', 'gambar_produk' => 'images/produk/bp_apparatus.png', 'persentase' => 70, 'link_detail' => 'https://example.com/bp-apparatus']
                ]);
                break;

            case 'farmasi-satelit':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Medicine Cabinet', 'gambar_produk' => 'images/produk/medicine_cabinet.png', 'persentase' => 85, 'link_detail' => 'https://example.com/medicine-cabinet'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Refrigerator', 'gambar_produk' => 'images/produk/refrigerator.png', 'persentase' => 80, 'link_detail' => 'https://example.com/refrigerator'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Weighing Scale', 'gambar_produk' => 'images/produk/scale.png', 'persentase' => 75, 'link_detail' => 'https://example.com/scale']
                ]);
                break;

            case 'farmasi-sentral':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Drug Storage Rack', 'gambar_produk' => 'images/produk/storage_rack.png', 'persentase' => 80, 'link_detail' => 'https://example.com/storage-rack'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Refrigerated Cabinet', 'gambar_produk' => 'images/produk/refrigerated_cabinet.png', 'persentase' => 85, 'link_detail' => 'https://example.com/refrigerated-cabinet'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Tablet Counter', 'gambar_produk' => 'images/produk/tablet_counter.png', 'persentase' => 70, 'link_detail' => 'https://example.com/tablet-counter']
                ]);
                break;

            case 'cssd':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Sterilizer Autoclave', 'gambar_produk' => 'images/produk/autoclave.png', 'persentase' => 85, 'link_detail' => 'https://example.com/autoclave'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Washer Disinfector', 'gambar_produk' => 'images/produk/washer_disinfector.png', 'persentase' => 75, 'link_detail' => 'https://example.com/washer-disinfector'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Packing Table', 'gambar_produk' => 'images/produk/packing_table.png', 'persentase' => 65, 'link_detail' => 'https://example.com/packing-table']
                ]);
                break;

            case 'gizi':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Food Warmer', 'gambar_produk' => 'images/produk/food_warmer.png', 'persentase' => 85, 'link_detail' => 'https://example.com/food-warmer'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Refrigerator', 'gambar_produk' => 'images/produk/refrigerator_gizi.png', 'persentase' => 75, 'link_detail' => 'https://example.com/refrigerator-gizi'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Mixer', 'gambar_produk' => 'images/produk/mixer.png', 'persentase' => 70, 'link_detail' => 'https://example.com/mixer']
                ]);
                break;

            case 'hd-bank-darah':
            Product::insert([
                ['room_id' => $newRoom->id, 'nama_produk' => 'Dialysis Machine','gambar_produk' => 'images/produk/dialysis_machine.png','persentase' => 85, 'link_detail' => 'https://example.com/dialysis-machine'],
                ['room_id' => $newRoom->id, 'nama_produk' => 'Blood Bank Refrigerator', 'gambar_produk' => 'images/produk/blood_bank_refrigerator.png', 'persentase' => 80, 'link_detail' => 'https://example.com/blood-bank-refrigerator'],
                ['room_id' => $newRoom->id, 'nama_produk' => 'Centrifuge for Blood Separation', 'gambar_produk' => 'images/produk/blood_centrifuge.png', 'persentase' => 75, 'link_detail' => 'https://example.com/blood-centrifuge']
            ]);
            break;

            case 'laundry':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Washing Machine', 'gambar_produk' => 'images/produk/washing_machine.png', 'persentase' => 80, 'link_detail' => 'https://example.com/washing-machine'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Dryer', 'gambar_produk' => 'images/produk/dryer.png', 'persentase' => 75, 'link_detail' => 'https://example.com/dryer'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Ironing Press', 'gambar_produk' => 'images/produk/ironing_press.png', 'persentase' => 70, 'link_detail' => 'https://example.com/ironing-press']
                ]);
                break;

            case 'mekanik':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'BMS (Schneider)', 'gambar_produk' => 'images/produk/bms.png', 'persentase' => 80, 'link_detail' => 'https://app.aspak-kemenkes.cloud/bmsdashboard'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Generator Set', 'gambar_produk' => 'images/produk/genset.png', 'persentase' => 85, 'link_detail' => 'https://example.com/genset'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Water Pump', 'gambar_produk' => 'images/produk/water_pump.png', 'persentase' => 70, 'link_detail' => 'https://example.com/water-pump']
                ]);
                break;

            case 'r-forensik-jenazah':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Autopsy Table', 'gambar_produk' => 'images/produk/autopsy_table.png', 'persentase' => 80, 'link_detail' => 'https://example.com/autopsy-table'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Cold Storage', 'gambar_produk' => 'images/produk/cold_storage.png', 'persentase' => 85, 'link_detail' => 'https://example.com/cold-storage'],
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Instrument Cabinet', 'gambar_produk' => 'images/produk/instrument_cabinet.png', 'persentase' => 70, 'link_detail' => 'https://example.com/instrument-cabinet']
                ]);
                break;

            case 'schneider':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'BMS (Schneider)', 'gambar_produk' => 'images/produk/bms.png', 'persentase' => 80, 'link_detail' => 'https://app.aspak-kemenkes.cloud/bmsdashboard'],
                ]);
                break;

            case 'its':
                Product::insert([
                    ['room_id' => $newRoom->id, 'nama_produk' => 'Timbangan (SECA)', 'gambar_produk' => 'images/produk/seca.png', 'persentase' => 30, 'link_detail' => 'https://app.aspak-kemenkes.cloud/dashseca']
                ]);
                break;
        }
    }


    }
}
