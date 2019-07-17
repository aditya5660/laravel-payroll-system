<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $fillable = [
        'id_jabatan',
        'nama_jabatan',
        'gaji_pokok',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
