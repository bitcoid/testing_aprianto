<?php 
namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator; 
use DB;

class KaryawanController extends Controller
{
    public function index() {} 
	
	public function searchKaryawan( Request $request )
    {  
		 
		return response()->json([
            'success' => true,
            'message' =>'List Semua Post',
            'data'    => $this->QuerySearchKaryawan($request->get('params'))
        ], 200);
    }
	
	public function QuerySearchKaryawan($filters){  
		
		$trans = Karyawan::select(
						'tbl_karyawan.karyawan_id as id', 
						'tbl_karyawan.nik',
						'tbl_karyawan.nama',
						'tbl_departement.department' )
					->join('tbl_departement', 'tbl_karyawan.karyawan_id', '=', 'tbl_departement.departement_id')
					->where('tbl_karyawan.nik', 'like', '%' . $filters . '%')
					->orWhere('tbl_karyawan.nama', 'like', '%' . $filters . '%')
					->get();
		return $trans;
	}
}
