<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTunjanganJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::create('tunjangan_jabatan', function (Blueprint $table) {
            $table->increments('id_tunjangan_jabatan');
            $table->unsignedInteger('id_jenis_tunjangan')->nullable();
            $table->foreign('id_jenis_tunjangan')
                ->on('jenis_tunjangan')
                ->references('id_jenis_tunjangan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedInteger('id_karyawan')->nullable();
            $table->foreign('id_karyawan')
                ->on('karyawan')
                ->references('id_karyawan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                $table->timestamps();
            $table->integer('besar_tunjangan')->unsigned()->nullable()->default(12);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tunjangan_jabatan');
    }
}
