<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTransaksiDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaksi_detail', function (Blueprint $table) { 
			$table->integer('qty');  
			$table->string('satuan',255); 
			$table->string('lokasi',255); 
			$table->string('ket',255);   
			$table->unsignedBigInteger('transaksi_id');			
			$table->foreign('transaksi_id')->references('transaksi_id')->on('tbl_transaksi')->onDelete('cascade');
			$table->unsignedBigInteger('barang_id');			
			$table->foreign('barang_id')->references('barang_id')->on('tbl_barang')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_transaksi_detail');
    }
}
