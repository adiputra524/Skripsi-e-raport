<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mata_pelajaran;
use DB;
use App\Rapor_header;
use App\Raport;
use App\Imports\MataPelajaranImport;
use App\Exports\MataPelajaranExport;
use Maatwebsite\Excel\Facades\Excel;

use Session;

class mata_pelajaranController extends Controller
{
	private function getTahunAjaran()
	{
		$tahunAjaran = "";
		$currentDate = new \DateTime("now");

		$currentYear = $currentDate->format('yy');

	    $epoch1Juli = strtotime("1 July {$currentYear}"); //Epoch

	    if(time() < $epoch1Juli){
	    	$tahunKemarin = (int) $currentYear - 1;
	    	$tahunAjaran = $tahunKemarin. "/" . $currentYear;
	    }else if(time() > $epoch1Juli){
	    	$tahunDepan = (int)$currentYear + 1;
	    	$tahunAjaran = $currentYear. "/" . $tahunDepan;
	    }

	    return $tahunAjaran;
	}

	public function IndexGetMataPelajaranKelas10() 
	{
		$mata_pelajaran = Mata_pelajaran::all();
		$mata_pelajaran = DB::table('rapor_headers as rh')
		->select('*')
		->join('mata_pelajarans','rapor_header_id','=','rh.id')
		->where('rh.id','!=','2')
		->get();
		return view('/internal/DaftarNilaiKelas10',compact('mata_pelajaran'));

	}

	public function IndexGetMataPelajaranKelas11() 
	{
		$mata_pelajaran = Mata_pelajaran::all();
		$mata_pelajaran = DB::table('rapor_headers as rh')
		->select('*')
		->join('mata_pelajarans','rapor_header_id','=','rh.id')
		->where('rh.id','!=','1')
		->get();

		return view('/internal/DaftarNilaiKelas11',compact('mata_pelajaran'));

	}

	public function IndexGetMataPelajaranKelas12() 
	{
		$mata_pelajaran = Mata_pelajaran::all();
		$mata_pelajaran = DB::table('rapor_headers as rh')
		->select('*')
		->join('mata_pelajarans','rapor_header_id','=','rh.id')

		->get();

		return view('/internal/DaftarNilaiKelas12',compact('mata_pelajaran'));

	}

	public function storeMataPelajaran(Request $request)
	{
		$raport = null;
		

		if($request->hasFile('select_file')){
			$raport = DB::table('raports as mp')
			->select('*')
			->where('student_id','=', pathinfo($request->file('select_file')->getClientOriginalName(), PATHINFO_FILENAME))
			->get()
			->first();
		}else{
			return redirect()->back();
		}

		if(!isset($raport)){
			$raport = new Raport();
			$raport->student_id = pathinfo($request->file('select_file')->getClientOriginalName(), PATHINFO_FILENAME);
			$raport->created_at = new \DateTime('now');

			$raport->save();
		}

		$raport_header = DB::table('rapor_headers as rh')
		->select('*')
		->where('rapor_id', '=', $raport->id)
		->get()
		->first();

		if(!isset($raport_header)){
			$raport_header = new Rapor_header();
			$raport_header->rapor_id = $raport->id;
			$raport_header->tahun_ajaran = $this->getTahunAjaran();	

			$raport_header->save();		
		}

		// dd($raport_header);


        // if(!isset($mata_pelajaran)){
        // 	$mata_pelajaran = new Mata_pelajaran();
        // 	$mata_pelajaran->


        // }
		// $mata_pelajaran = DB::table('mata_pelajarans as mp')
		// ->select('*')
		// ->where('id','=',$mata_pelajaran->raport_header_id)
		// // ->where('raport_header_id','!=','7')
		// ->get()
		// ->first();

		// if(!isset($mata_pelajaran)){
		// 	$mata_pelajaran = new Mata_pelajaran();
		// 	$mata_pelajaran -> Session::get('raport_header_id');

		// 	$mata_pelajaran->nama_mata_pelajaran = $this->nama_mata_pelajaran();	

		// 	$mata_pelajaran->nilai_uts = $this->nilai_uts();
		// 	$mata_pelajaran->nilai_uas = $this->nilai_uas();
		// 	$mata_pelajaran->catatan = $this->catatan();

		// 	$mata_pelajaran->save();		
		// }

		Session::put('raport_header_id', $raport_header->id);

		$mata_pelajaran = new MataPelajaranImport();

		$data = Excel::import($mata_pelajaran,$request->file('select_file'));

		Session::forget('raport_header_id');

		return redirect('/pelajaran/internal/ImportNilai')->with('success','Nilai Siswa Telah Masuk');
		
	}

	
	public function IndexImportNilai()
	{
		return view('/internal/ImportNilai');
	}

	public function exportNilai10()
	{
		return Excel::download(new MataPelajaranExport,'Nilai10.xlsx');
	}

	public function exportNilai11()
	{
		return Excel::download(new MataPelajaranExport,'Nilai11.xlsx');
	}

	public function exportNilai12()
	{
		return Excel::download(new MataPelajaranExport,'Nilai12.xlsx');
	}





	public function editMataPelajaran($id)
	{
		$mata_pelajaran = Mata_pelajaran::find($id);
		return view('',[''=>$mata_pelajaran]);
	}

	public function updateMataPelajaran($id,Request $request)
	{
		$this->validate($request,[
			'rapor_header_id' =>'required',
			'nama_mata_pelajaran' =>'required',
			'nilai_uts' =>'required',
			'nilai_uas' =>'required',
			'catatan' =>'required'
		]);
		$mata_pelajaran = Mata_pelajaran::find($id);
		$mata_pelajaran = $request->rapor_header_id;
		$mata_pelajaran =$request ->nama_mata_pelajaran;
		$mata_pelajaran = $request->nilai_uts;
		$mata_pelajaran = $request->nilai_uas;
		$mata_pelajaran = $request->catatan;
		$mata_pelajaran->save();
		return redirect('');

	}

	public function deleteMataPelajaran($id)
	{
		$mata_pelajaran = Mata_pelajaran::find($id);
		$mata_pelajaran->delete();
		return redirect('');
	}

}
