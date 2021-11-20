<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_barang', function (Blueprint $table) {  
			$table->bigIncrements('barang_id');
			$table->string('kode',255); 
			$table->string('nama_brg',255); 
			$table->string('lokasi',255); 
			$table->integer('stok');
			$table->enum('satuan', ['pak','box']);
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
        Schema::dropIfExists('tbl_barang');
    }
}
