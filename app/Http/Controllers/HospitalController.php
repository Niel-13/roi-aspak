<?php
namespace App\Http\Controllers;
use App\Models\Hospital;
use App\Models\Room;
use App\Models\Floor;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function show(Hospital $hospital)
    {
        // Load data relasi
        $hospital->load('kabupaten.provinsi', 'floors.rooms');

        // Ambil data untuk dropdown header
        $all_provinsis = Provinsi::all()->keyBy('nama');
        $currentDateTime = \Carbon\Carbon::now();

        // Ambil lantai pertama sebagai default
        $currentFloor = $hospital->floors->first();
        $rooms = $currentFloor ? $currentFloor->rooms : collect();

        return view('hospital-detail', [
            'hospital' => $hospital,
            'provinsi' => $hospital->kabupaten->provinsi,
            'kabupaten' => $hospital->kabupaten,
            'floors' => $hospital->floors,
            'currentFloor' => $currentFloor,
            'rooms' => $rooms,
            'all_provinsis' => $all_provinsis,
            'currentDateTime' => $currentDateTime,
        ]);
    }

    /**
     * Mengembalikan data produk untuk ruangan tertentu (API)
     */
    public function getProducts(Room $room)
    {
        // Load produk dan kirim sebagai JSON
        $products = $room->products;
        return response()->json($products);
    }
}