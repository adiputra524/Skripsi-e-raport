<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mata_pelajaran;
use DB;
use App\Rapor_header;
use App\Raport;
use App\TblStudent;
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

	private function parseTahunAjaran($string){
		$tahun = $string;

		for($i =0; $i< strlen($tahun); $i++){
			if($tahun[$i] == '-'){
				$tahun[$i] = '/';
			}
		}	

		return $tahun;
	}

	private function createSemester(){
		$currentDate = new \DateTime("now");

		if($currentDate->format('m') > 7)
			return 1;
		
		return 2;
	}

	public function IndexMataPelajaran($id) 
	{
		$raport = DB::table('raports as r')
		->select('*')
		->join('rapor_headers as rh', 'rh.rapor_id', '=', 'r.id')
		->join('mata_pelajarans as mp','mp.rapor_header_id','=','rh.id')
		->where('student_id','=', $id)
		->get();
		// dd($raport);

		return view('/internal/DaftarNilaiSiswa',compact('raport'));
	}

	public function storeMataPelajaran(Request $request)
	{
		if(!$request->hasFile('select_file')){
			return redirect()->back(); //Kalo gaada filenya, balikin ke page tadi
		}

		#Parsing Name Filenya untuk get Student ID, Kelas, Semester, sama Tahun Ajaran
		$filename = pathinfo($request->file('select_file')->getClientOriginalName(),  PATHINFO_FILENAME);
		$flagMinPertama = -1;
		$flagMinKedua  = -1;
		$flagMinKetiga = -1;

		for($i = 0; $i< strlen($filename); $i++)
		{
			if($filename[$i] =='-'){
				if($flagMinPertama == -1){
				
					$flagMinPertama = $i;
				}else if($flagMinKedua == -1){
					
					$flagMinKedua = $i;
				}else if($flagMinKetiga == -1){
					
					$flagMinKetiga = $i;
				}
			}
		}

		// die();

		$studentId = substr($filename, 0, $flagMinPertama);
		$classId = substr($filename, $flagMinPertama+1, ($flagMinKedua - $flagMinPertama)-1);
		$ganjilGenap = substr($filename, $flagMinKedua+1, ($flagMinKetiga - $flagMinKedua)-1);
		$tahunAjaran = substr($filename, $flagMinKetiga+1, (strlen($filename) - $flagMinKetiga)-1);

			
			if($flagMinPertama = -1) redirect('/pelajaran/internal/ImportNilai')->with('fail','Data tidak sesuai');
			
			if($flagMinKedua == -1) redirect('/pelajaran/internal/ImportNilai')->with('fail','Data tidak Sesuai');
			
			if($flagMinKetiga == -1) redirect('/pelajaran/internal/ImportNilai')->with('fail','Data tidak Sesuai');
			 
		$studentId = Raport::find($student_id);
		
		
		$ClassId = TblStudent::find($class_id);
		
		#Check Raportnya ada atau nggak
		$raport = DB::table('raports')
			->select('*')
			->where('student_id','=', $studentId)
			->get()
			->first();


		if(!isset($raport)){
			$raport = new Raport();
			$raport->student_id = $studentId;
			$raport->created_at = new \DateTime('now');
			$raport->save();
		}

		//Check Raport Header berdasarkan Tahun Ajaran dan semester
			$raport_header = DB::table('rapor_headers as rh')
			->select('*')
			->where('rh.rapor_id', '=', $raport->id)
			->where('rh.tahun_ajaran', '=', $this->parseTahunAjaran($tahunAjaran))
			->where('rh.semester','=',$ganjilGenap)
			->orderBy('rh.tahun_ajaran', 'asc')
			->get()
			->first();

			if(!isset($raport_header)){
				$raport_header = new Rapor_header();
				$raport_header->rapor_id = $raport->id;
				$raport_header->tahun_ajaran = $this->parseTahunAjaran($tahunAjaran);	
				$raport_header->semester = ($ganjilGenap);
                
				$raport_header->save();		
			}

		


			Session::put('raport_header_id', $raport_header->id);
			// Session::put('rapor_header_id',$raport->id);

			$mata_pelajaran = new MataPelajaranImport();

			$data = Excel::import($mata_pelajaran,$request->file('select_file'));

			Session::forget('raport_header_id');
			// Session::forget('rapor_header_id');

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
