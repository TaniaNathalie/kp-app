<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Presensi;

Use Carbon\Carbon;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(){
        $karyawans = Karyawan::orderBy('nama_karyawan', 'asc')->get();
        return view('karyawan', 
        ['karyawans' => $karyawans]);
        
    }

    public function show($id_karyawan) {
        $hrds = Presensi::where('id_karyawan', $id_karyawan)
                        ->orderBy('id_presensi', 'desc')
                        ->take(20)
                        ->get();
    
        $selisihArrayBulanIni = [];
        $selisihArrayTahunIni = [];
        $sekarang = Carbon::now();
    
        foreach ($hrds as $presensi) {
            $presensiMasuk = Carbon::parse($presensi->presensi_masuk);
            $presensiKeluar = Carbon::parse($presensi->presensi_keluar);
    
            if ($presensiMasuk->month == $sekarang->month) {
                $selisihArrayBulanIni[] = $presensiMasuk->diff($presensiKeluar)->format('%H:%I:%S');
            }
    
            if ($presensiMasuk->year == $sekarang->year) {
                $selisihArrayTahunIni[] = $presensiMasuk->diff($presensiKeluar)->format('%H:%I:%S');
            }
        }
    
        // Hitung total selisih untuk bulan ini
        $totalBulanIni = array_sum(array_map('strtotime', $selisihArrayBulanIni));
    
        // Hitung total selisih untuk tahun ini
        $totalTahunIni = array_sum(array_map('strtotime', $selisihArrayTahunIni));
    
        return view('karyawan.detail_karyawan', [
            'hrds' => $hrds,
            'selisihArrayBulanIni' => $selisihArrayBulanIni,
            'selisihArrayTahunIni' => $selisihArrayTahunIni,
            'totalBulanIni' => gmdate('H:i:s', $totalBulanIni),
            'totalTahunIni' => gmdate('H:i:s', $totalTahunIni),
        ]);
    }
    

    
    

}
