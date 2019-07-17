<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisTunjangan extends Model
{

        protected $table = 'jenis_tunjangan';
        protected $fillable = ['id_jenis_tunjangan', 'nama_jenis_tunjangan'];


}
