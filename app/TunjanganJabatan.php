<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TunjanganJabatan extends Model
{
    protected $table = ['tunjangan_jabatan'];
    protected $fillable = ['id_tunjangan_jabatan', 'id_jenis_tunjangan', 'id_karyawan', 'besar_tunjangan'];
}
