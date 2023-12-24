<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    public function presensi(){
        return $this->hasMany(Presensi::class, 'id_karyawan', 'id_karyawan');
    }
   
}
