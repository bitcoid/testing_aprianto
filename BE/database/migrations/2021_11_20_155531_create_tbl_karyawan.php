<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_karyawan', function (Blueprint $table) {
            $table->bigIncrements('karyawan_id');
			$table->string('nik',255);  
			$table->string('nama',255);  
			$table->unsignedBigInteger('departement_id');			
			$table->foreign('departement_id')->references('departement_id')->on('tbl_departement')->onDelete('cascade');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_karyawan');
    }
}
