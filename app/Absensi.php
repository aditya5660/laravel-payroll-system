<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = [
        'absensi'
    ];
    protected $fillable = [
        'id_absensi', 'id_karyawan','kehadiran','waktu_masuk','waktu_keluar','tgl_absensi','created_at','updated_at'
    ];
}
