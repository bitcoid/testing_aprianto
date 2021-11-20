<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaksi', function (Blueprint $table) {
            $table->bigIncrements('transaksi_id');
			$table->timestamp('tgl_request')->useCurrent = true;   
			$table->unsignedBigInteger('karyawan_id');			
			$table->foreign('karyawan_id')->references('karyawan_id')->on('tbl_karyawan')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_transaksi');
    }
}
