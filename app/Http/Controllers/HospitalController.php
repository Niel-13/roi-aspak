<?php
namespace App\Http\Controllers;
use App\Models\Hospital;
use App\Models\Room;
use App\Models\Floor;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function show(Hospital $hospital, Request $request)
{
    $hospital->load('kabupaten.provinsi', 'floors.rooms');
    $all_provinsis = Provinsi::all()->keyBy('nama');
    $currentDateTime = \Carbon\Carbon::now();
    $floorId = $request->query('floor');
    if ($floorId) {
        $currentFloor = $hospital->floors->where('id', $floorId)->first();
    } else {
        $currentFloor = $hospital->floors->first();
    }
    if (!$currentFloor) {
        $currentFloor = $hospital->floors->first();
    }

    $rooms = $currentFloor ? $currentFloor->rooms->keyBy('kode_svg') : collect();
    $namaFileDenah = $currentFloor ? $currentFloor->gambar_denah : null;

    return view('hospital-detail', [
        'hospital' => $hospital,
        'provinsi' => $hospital->kabupaten->provinsi,
        'kabupaten' => $hospital->kabupaten,
        'floors' => $hospital->floors,
        'currentFloor' => $currentFloor,
        'rooms' => $rooms,
        'namaFileDenah' => $namaFileDenah,
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