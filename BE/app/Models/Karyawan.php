<?php

namespace App\Models; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Karyawan extends Model
{
    use HasFactory;   
    /**
     * @var string
     */
    protected $table = 'tbl_karyawan';
	protected $primaryKey =  'id'; 
	public $incrementing = false;
    /**
     * @var array
     */
    protected $fillable = [
         'nik','nama', 'departement_id'
    ]; 
	
	public function posts() {
      return $this->hasMany(Karyawan::class);
    }
	
}