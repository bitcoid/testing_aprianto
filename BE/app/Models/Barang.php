<?php

namespace App\Models; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;
	/**
     * @var string
     */
    protected $table = 'tbl_barang';
	
	protected $primaryKey =  'id';
	
	public $incrementing = false;
    /**
     * @var array
     */
    protected $fillable = [
       'kode','nama_brg', 'lokasi','stok','satuan'
    ];

    public function posts() {
      return $this->hasMany(Barang::class);
    }	
	
}