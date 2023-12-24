<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Karyawan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard() {
        $startOfMonth = Carbon::now()->startOfMonth();;
        $endOfMonth = Carbon::now()->endOfMonth();

        $rowCount = Presensi::whereBetween('presensi_masuk', [$startOfMonth, $endOfMonth])->count();

        $jumlahApproved = Presensi::where('id_approval', 1)
                                  ->whereBetween('presensi_masuk', [$startOfMonth, $endOfMonth])
                                  ->count();
        
        $jumlahRejected = Presensi::where('id_approval', 0)
                                  ->whereBetween('presensi_masuk', [$startOfMonth, $endOfMonth])
                                  ->count();

        $namaBulan = Carbon::now()->translatedFormat('F');
        // $namaBulan = Carbon::now()->subMonth()->format('F');

        $todayDate = Carbon::now()->toDateString();
        $parsedDate = Carbon::parse($todayDate);
        setlocale(LC_TIME, 'id'); // Mengatur locale ke bahasa Indonesia
        $formattedDate = $parsedDate->formatLocalized('%A, %d %B %Y');

        $totalKaryawan = Karyawan::count();

        return view('dashboard', [
            'rowCount' => $rowCount,
            'jumlahApproved' => $jumlahApproved,
            'jumlahRejected' => $jumlahRejected,
            'namaBulan' => $namaBulan,
            'totalKaryawan' => $totalKaryawan,
            'formattedDate' => $formattedDate
        ]);
    }

}
