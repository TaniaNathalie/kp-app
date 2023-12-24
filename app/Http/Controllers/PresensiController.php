<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Http\Requests\StorePresensiRequest;
use App\Http\Requests\UpdatePresensiRequest;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $hrds = Presensi::join('karyawan', 'presensi.id_karyawan', '=', 'karyawan.id_karyawan')
                ->orderBy('presensi.id_presensi', 'desc')
                ->take(50) // Ambil 10 data teratas
                ->get(); // Sesuaikan kolom yang Anda inginkan dari kedua tabel


        $jlhApproved = $hrds->where('id_approval', 1)->count();
        $jlhRejected =  $hrds->where('id_approval', 0)->count();
        

        return view('daftar_presensi', ['hrds' => $hrds, 
        'jlhApproved' => $jlhApproved,
        'jlhRejected' => $jlhRejected]);
        
    }

    // public function getDataFromDB(){
    //     $hrds = Presensi::join('karyawan', 'presensi.id_karyawan', '=', 'karyawan.id_karyawan')
    //                     ->orderBy('presensi.id_presensi', 'desc')
    //                     ->take(50) // Ambil 10 data teratas
    //                     ->get();
    //     return response()->json($hrds);
    // }

    public function update($id_presensi){
        $hrd = Presensi::find($id_presensi);
        if($hrd){
            if($hrd->id_approval){
                $hrd->id_approval = 0;
                $hrd->is_edit = 1;
            }
            else{
                $hrd->id_approval = 1;
                $hrd->is_edit = 0;
            }
        $hrd->save();
    }
    return back();
    }

    public function approveAll(\Illuminate\Http\Request $request)
    {
        $selectedIds = $request->input('selected', []);

        Presensi::whereIn('id_presensi', $selectedIds)->update(['id_approval' => '1', 'is_edit' => '0']);

        return redirect()->back()->with('success', 'Semua data yang dicentang berhasil disetujui.');
    }


    // public function countRowsPerMonth() {
    //     $startOfMonth = Carbon::now()->startOfMonth();
    //     $endOfMonth = Carbon::now()->endOfMonth();

    //     $rowCount = Presensi::whereBetween('presensi_masuk', [$startOfMonth, $endOfMonth])->count();

    //     return view('dashboard', ['rowCount' => $rowCount]);
    // }

    public function countStartEndDate(\Illuminate\Http\Request $request)
{
    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');

    // Lakukan query ke database untuk menghitung jumlah approved dan rejected
    $jlhApproved = Presensi::where('id_approval', 1)
        ->whereBetween('presensi_masuk', ["$startDate 00:00:00", "$endDate 23:59:59"])
        ->count();

    $jlhRejected = Presensi::where('id_approval', 0)
        ->whereBetween('presensi_masuk', ["$startDate 00:00:00", "$endDate 23:59:59"])
        ->count();

    // Kirim response ke frontend
    return response()->json([
        'jlhApproved' => $jlhApproved,
        'jlhRejected' => $jlhRejected,
    ]);
}

public function getDefaultDataForReset()
{
    $hrds = Presensi::join('karyawan', 'presensi.id_karyawan', '=', 'karyawan.id_karyawan')
                    ->orderBy('presensi.id_presensi', 'desc')
                    ->take(50) // Ambil 10 data teratas
                    ->get();

    $jlhApproved = $hrds->where('id_approval', 1)->count();

    $jlhRejected =  $hrds->where('id_approval', 0)->count();
    
    $defaultData = [
        'totalApproved' => $jlhApproved, // Ganti dengan nilai yang sesuai dari database atau logika Anda
        'totalRejected' => $jlhRejected, // Ganti dengan nilai yang sesuai dari database atau logika Anda
    ];

    return response()->json($defaultData);
    //return response()->json($defaultData);
}
}
