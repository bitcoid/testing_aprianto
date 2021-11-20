<?php

namespace App\Models; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Transaksi extends Model
{
    use HasFactory; 
	/**
     * @var stringTransaksi
     */
    protected $table = 'tbl_transaksi';
    protected $primaryKey =  'id';
	
	public $incrementing = false;
    /**
     * @var array
     */
    protected $fillable = [
        'karyawan_id', 'tgl_request'
    ]; 
	
	public function posts() {
      return $this->hasMany(Transaksi::class);
    }
	
	
}