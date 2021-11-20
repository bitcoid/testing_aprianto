<?php

namespace App\Models; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Departement extends Model
{
    use HasFactory;   
    /**
     * @var string
     */
    protected $table = 'tbl_departement';
	protected $primaryKey =  'id'; 
	public $incrementing = false;
    /**
     * @var array
     */
    protected $fillable = [ 'department' ];

	public function posts() {
      return $this->hasMany(Departement::class);
    }		
	
}