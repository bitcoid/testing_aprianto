<?php 
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use DB;

class PermintaanController extends Controller
{
    public function index()
    {
        
        return response()->json([
            'success' => true,
            'message' =>'List Semua Post',
            'data'    => $this->getList()
        ], 200);
    }
	
	public function getList(){  
		
		$trans = Transaksi::select(
						'tbl_transaksi.transaksi_id as id',
						'tbl_transaksi.tgl_request',
						'tbl_karyawan.nik',
						'tbl_karyawan.nama',
						'tbl_departement.department', 
						DB::raw('(select count(tbl_transaksi_detail.transaksi_id) as jml 
								 from tbl_transaksi_detail where tbl_transaksi_detail.transaksi_id = tbl_transaksi.transaksi_id) as `jml_brg`')
						)
					->join('tbl_karyawan','tbl_transaksi.karyawan_id', '=', 'tbl_karyawan.karyawan_id')
					->join('tbl_departement', 'tbl_karyawan.departement_id', '=', 'tbl_departement.departement_id')  
					->paginate(5); 
		return $trans;
	}
	
	public function create(Request $request){
		try{
			$this->validate($request, [
					'tgl_request' => 'required',
					'karyawan_id' => 'required',
					'listbarang' => 'required'
				],
				[ 
				   'karyawan_id.required' => 'Nik Karyawan is required',  
				   'tgl_request.required' => 'Tgl  is required',  
				   'listbarang.required' => 'List Barang is required',
				]
			); 
			  
			
		   $data = $request->all();
		   $trans = Transaksi::create($data); 
		   $message = '';
		   if($trans){
			   $rowId = DB::connection() -> getPdo() -> lastInsertId();
			   $listbarang = $request->input('listbarang');
			   for($i=0; $i < count($listbarang); $i++){
				if($listbarang[$i]['id_barang'] !="" && $listbarang[$i]['qty'] != ""){
				   $idbrg = $listbarang[$i]['id_barang'];
				   $qty = $listbarang[$i]['qty'];
				   $satuan = $listbarang[$i]['satuan'];
				   $lokasi = $listbarang[$i]['lokasi'];
				   $ket = $listbarang[$i]['ket'];
				   $result = DB::insert(
							 "insert into tbl_transaksi_detail 
							 (transaksi_id,barang_id,qty,satuan,lokasi,ket) values 
							  ( 
							  $rowId, 
							  '".$idbrg."',
							  '".$qty."',
							  '".$satuan."',
							  '".$lokasi."',
							  '".$ket."'
							  )"  
						   );
				   
				   $brg = Barang::where('barang_id',$idbrg)->first();
				   if($brg){
					   $stok_akhir =  $brg->stok - $qty;
					   DB::table('tbl_barang')->where('barang_id', $idbrg)
					   ->update(['stok' => $stok_akhir  ]); 
				   }
				   
				}   
			   }
		   }
		  
		    return response()->json([
				'success' => true,
				'message' => 'Berhasil Simpan data',
				'data'    => $trans
			], 200);
			 
		}
		catch(Exception $e)
		{
			if ($e instanceof HttpException && $e->getStatusCode()== 401)
			{
			  dd('you are not authorized');
			}
		} 
	}
	
	public function transactionViewHeader(Request $request){ 
		$trans = Transaksi::select(
						'tbl_transaksi.transaksi_id as id',
						'tbl_transaksi.tgl_request',
						'tbl_karyawan.nik',
						'tbl_karyawan.nama',
						'tbl_departement.department')
					->join('tbl_karyawan','tbl_transaksi.karyawan_id', '=', 'tbl_karyawan.karyawan_id')
					->join('tbl_departement', 'tbl_karyawan.departement_id', '=', 'tbl_departement.departement_id')
					->where('tbl_transaksi.transaksi_id','=', $request->input('id'))
					->get(); 
		return response()->json([
				'success' => true,
				'message' => 'Berhasil view data',
				'data'    => $trans
			], 200);
	}
	 
	public function transactionBaranglist(Request $request){ 
		$trans = TransaksiDetail::select(
						'tbl_transaksi_detail.transaksi_id as id', 
						DB::raw("CONCAT(tbl_barang.kode,' - ',tbl_barang.nama_brg)  AS nama_item"),
						'tbl_barang.nama_brg',
						'tbl_transaksi_detail.qty',
						'tbl_transaksi_detail.satuan',
						'tbl_transaksi_detail.lokasi',
						'tbl_transaksi_detail.ket')
					->join('tbl_barang','tbl_barang.barang_id', '=', 'tbl_transaksi_detail.barang_id') 
					->where('tbl_transaksi_detail.transaksi_id','=', $request->input('id'))
					->paginate(10); 
		return response()->json([
				'success' => true,
				'message' => 'Berhasil view data',
				'data'    => $trans
			], 200);
	}
	
}
