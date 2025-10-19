<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\PointOfInterest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $provinsis = Provinsi::all()->keyBy('nama');
        $pointsOfInterest = PointOfInterest::all();
        $currentDateTime = Carbon::now();
        return view('roi', compact('provinsis', 'pointsOfInterest', 'currentDateTime'));
    }

    public function show($namaProvinsi)
    {
        $provinsi = Provinsi::where('nama', $namaProvinsi)->firstOrFail();
        $pointsOfInterest = $provinsi->pointsOfInterest()->get();
        $tingkatan = $this->getTingkatanByPersentase($provinsi->persentase);
        $namaFileSvg = strtolower(str_replace(' ', '_', $provinsi->nama)) . '.svg';
        return response()->json([
            'nama' => $provinsi->nama,
            'pointsOfInterest' => $pointsOfInterest,
            'namaFileSvg' => $namaFileSvg,
            'tingkatan' => $tingkatan,
            'persentase' => $provinsi->persentase
        ]);
    }

    public function showProvinsiDetail($nama)
    {
        $provinsi = Provinsi::where('nama', $nama)->firstOrFail(); 
        $kabupatens = $provinsi->kabupaten()->get()->keyBy('nama'); 
        $pointsOfInterest = $provinsi->pointsOfInterest()->get();
        $currentDateTime = \Carbon\Carbon::now();

        return view('provinsi-detail', [
            'provinsi' => $provinsi,
            'kabupatens' => $kabupatens,
            'pointsOfInterest' => $pointsOfInterest,
            'currentDateTime' => $currentDateTime
        ]);
    }

    private function getTingkatanByPersentase($persentase)
    {
        if ($persentase >= 81) {
            return '81-100%';
        } elseif ($persentase >= 61) {
            return '61-80%';
        } elseif ($persentase >= 41) {
            return '41-60%';
        } elseif ($persentase >= 21) {
            return '21-40%';
        } else {
            return '0-20%';
        }
    }

    
}