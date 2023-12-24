<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/', 'App\Http\Controllers\DashboardController@dashboard');

Route::get('/daftar_presensi', 'App\Http\Controllers\PresensiController@index');
Route::get('daftar_presensi/{id_presensi}', 'App\Http\Controllers\PresensiController@update');
Route::get('/approve-all', 'App\Http\Controllers\PresensiController@approveAll')->name('approve-all');

Route::get('/karyawan', 'App\Http\Controllers\KaryawanController@index');
Route::get('/karyawan/{id_karyawan}', 'App\Http\Controllers\KaryawanController@show')->name('karyawan');

Route::get('/get-data-from-database', 'App\Http\Controllers\PresensiController@getDataFromDB');

Route::get('/get-data-from-dbb', 'App\Http\Controllers\PresensiController@countStartEndDate');
Route::get('/get-count-approved-rejected', 'App\Http\Controllers\PresensiController@getDefaultDataForReset');


