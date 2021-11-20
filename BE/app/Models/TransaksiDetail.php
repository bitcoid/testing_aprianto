<?php

namespace App\Models; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransaksiDetail extends Model
{
    /**
     * @var string
     */
    protected $table = 'tbl_transaksi_detail';

    /**
     * @var array
     */
    protected $fillable = [
        'transaksi_id', 'barang_id','qty','satuan','lokasi','ket'
    ]; 
	
}