<?php 
namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator; 
use DB;

class BarangController extends Controller
{
     
	public function index()
    {   
		return response()->json([
            'success' => true,
            'message' =>'List Semua Post',
            'data'    => $this->QueryBarangAll()
        ], 200);
    }
	
	public function QueryBarangAll(){  
		$trans = Barang::select( 'barang_id as id',
					 DB::raw("CONCAT(kode,' - ',nama_brg)  AS nama"),
					 'stok','lokasi', 'satuan'
					)  
					->get();
		return $trans;
	}
}
