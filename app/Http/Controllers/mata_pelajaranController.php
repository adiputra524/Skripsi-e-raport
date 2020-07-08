<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mata_pelajaran;
use DB;
use App\Rapor_header;
use App\Raport;
use App\TblStudent;
use App\Kelas;
use App\Imports\MataPelajaranImport;
use App\Exports\MataPelajaranExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exporter;

use Session;


class mata_pelajaranController extends Controller
{
	private function getTahunAjaran()
	{
		$tahunAjaran = "";
		$currentDate = new \DateTime("now");

		$currentYear = $currentDate->format('yy');

		$epoch1Juli = strtotime("1 July {$currentYear}"); //Epoch

		if (time() < $epoch1Juli) {
			$tahunKemarin = (int) $currentYear - 1;
			$tahunAjaran = $tahunKemarin . "/" . $currentYear;
		} else if (time() > $epoch1Juli) {
			$tahunDepan = (int) $currentYear + 1;
			$tahunAjaran = $currentYear . "/" . $tahunDepan;
		}

		return $tahunAjaran;
	}

	private function parseTahunAjaran($string)
	{
		$tahun = $string;

		for ($i = 0; $i < strlen($tahun); $i++) {
			if ($tahun[$i] == '-') {
				$tahun[$i] = '/';
			}
		}

		return $tahun;
	}

	private function createSemester()
	{
		$currentDate = new \DateTime("now");

		if ($currentDate->format('m') > 7)
			return 1;

		return 2;
	}

	public function IndexMataPelajaran($id)
	{



		$Grade = Kelas::find('grade');
		$Semester = Rapor_header::find('semester');
		$kelas = Kelas::find('class_name');

		$student = DB::table('tbl_students as tb')
			->select('*')
			->join('raports as r', 'tb.id', '=', 'r.student_id')
			->join('rapor_headers as rh', 'rh.rapor_id', '=', 'r.id')
			->where('tb.id', '=', $id)
			->get()
			->first();


		$GradeStudent = DB::table('kelas as k')
			->select('*')
			->join('tbl_students as tb', 'tb.class_id', '=', 'k.id')
			->join('raports as r', 'r.student_id', '=', 'tb.id')
			->join('rapor_headers as rh', 'rh.rapor_id', '=', 'r.id')
			->where('tb.id', '=', $id)
			->where('rh.semester', '=', $id)
			->get()
			->first();





		$rapot_bundle = [];


		for ($i = 10; $i <= $student->grade; $i++) {
			$data = DB::table('mata_pelajarans as m')
				->join('rapor_headers as k', 'k.id', '=', 'm.rapor_header_id')
				->join('raports as r', 'r.id', '=', 'k.rapor_id')
				->where('r.student_id', '=', $id)
				->get();
				
				
			array_push($rapot_bundle, $data, $student);
		}





	



		$raport = DB::table('raports as r')
			->join('rapor_headers as t', 'r.id', '=', 't.rapor_id')
			->join('mata_pelajarans as m', 'r.id', '=', 'm.rapor_header_id')
			->where('r.student_id', '=', $id)
			->get();
			

		

		

		return view('/internal/DaftarNilaiSiswa', compact('raport'));
	}

	public function storeMataPelajaran(Request $request)
	{
		if (!$request->hasFile('select_file')) {
			return redirect()->back(); //Kalo gaada filenya, balikin ke page tadi
		}

		#Parsing Name Filenya untuk get Student ID, Kelas, Semester, sama Tahun Ajaran
		$filename = pathinfo($request->file('select_file')->getClientOriginalName(),  PATHINFO_FILENAME);
		$flagMinPertama = -1;
		$flagMinKedua  = -1;
		$flagMinKetiga = -1;

		for ($i = 0; $i < strlen($filename); $i++) {
			if ($filename[$i] == '-') {
				if ($flagMinPertama == -1) {
					$flagMinPertama = $i;
				} else if ($flagMinKedua == -1) {
					$flagMinKedua = $i;
				} else if ($flagMinKetiga == -1) {
					$flagMinKetiga = $i;
				}
			}
		}

		$studentId = substr($filename, 0, $flagMinPertama);
		$Grade = substr($filename, $flagMinPertama + 1, ($flagMinKedua - $flagMinPertama) - 1);
		$ganjilGenap = substr($filename, $flagMinKedua + 1, ($flagMinKetiga - $flagMinKedua) - 1);
		$tahunAjaran = substr($filename, $flagMinKetiga + 1, (strlen($filename) - $flagMinKetiga) - 1);


		if ($flagMinPertama == -1) {
			Session::flash('error', 'Nama file tidak sesuai!');
			return redirect('/pelajaran/internal/ImportNilai');
		}

		if ($flagMinKedua == -1) {
			Session::flash('error', 'Nama file tidak sesuai!');
			return redirect('/pelajaran/internal/ImportNilai');
		}

		if ($flagMinKetiga == -1) {
			Session::flash('error', 'Nama file tidak sesuai!');
			return redirect('/pelajaran/internal/ImportNilai');
		}




		$student_Id = TblStudent::find($studentId);
	
		// $current_Date = Rapor_header::find($student_Id->student_id);
	   $current_Date = DB::table('rapor_headers as rh')
	   ->select('*')
	   ->join('raports as r','rh.rapor_id','=','r.id')
	   ->join('tbl_students as tb','r.student_id','=','tb.id')
	   ->where('tb.id','=',$student_Id->id)
	   ->get()
	   ->first();

	   

	   $KelasSemester = ($current_Date->semester);
	 

		if ($student_Id == null) {
			Session::flash('error', 'Murid dengan id ' . $studentId . ' tidak ditemukan!');
			return redirect('/pelajaran/internal/ImportNilai');
		}


		$class = Kelas::find($student_Id->class_id);
	    
		
		if ($class->grade  !=$Grade || $KelasSemester !=$ganjilGenap) {
			Session::flash('error', 'Data nilai yang anda masukan untuk ' . $student_Id->nama . ' tidak valid! Silahkan cek kembali kelas murid dan nama file yang anda upload!');
			return redirect('/pelajaran/internal/ImportNilai');
		}

		#Check Raportnya ada atau nggak
		$raport = DB::table('raports')
			->select('*')
			->where('student_id', '=', $studentId)
			->get()
			->first();


		if (!isset($raport)) {
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
			->where('rh.semester', '=', $ganjilGenap)
			->orderBy('rh.tahun_ajaran', 'asc')
			->get()
			->first();

		if (!isset($raport_header)) {
			$raport_header = new Rapor_header();
			$raport_header->rapor_id = $raport->id;
			$raport_header->tahun_ajaran = $this->parseTahunAjaran($tahunAjaran);
			$raport_header->semester = ($ganjilGenap);
			$raport_header->grade = ($Grade);
			$raport_header->save();
		}




		Session::put('raport_header_id', $raport_header->id);
		// Session::put('rapor_header_id',$raport->id);

		$mata_pelajaran = new MataPelajaranImport();

		$data = Excel::import($mata_pelajaran, $request->file('select_file'));

		Session::forget('raport_header_id');
		// Session::forget('rapor_header_id');

		Session::flash('success', 'Sukses memasukan nilai siswa!');

		return redirect('/pelajaran/internal/ImportNilai');
	}


	public function IndexImportNilai()
	{
		return view('/internal/ImportNilai');
	}



	public function exportNilai($rapor_header_id)
	{

		$query = DB::table('mata_pelajarans as mp')
			->join('rapor_headers as rh', 'mp.rapor_header_id', '=', 'rh.id')
			->join('raports as r', 'rh.rapor_id', '=', 'r.id')
			->join('tbl_students as tb', '.student_id', '=', 'tb.id')
			->where('mp.rapor_header_id', '=', $rapor_header_id)
			->get()
			->first();


		return Excel::download(new MataPelajaranExport($query), 'NilaiUjian.xlsx');
	}
	public function deleteMataPelajaran($id)
	{
		$mata_pelajaran = Mata_pelajaran::find($id);
		$mata_pelajaran->delete();
		return redirect('');
	}
}
