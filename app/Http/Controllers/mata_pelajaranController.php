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

use App\Exports\MappingRapot;
use Exception;
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

	public function IndexMataPelajaran($id, Request $request)
	{
		$raport = DB::table('raports as r')
			->select('r.student_id', 'r.id as rapor_id')
			->where('r.student_id', '=', $id)
			->get()
			->first();

		if ($raport == null) {
			return view('/internal/DaftarNilaiSiswa', [
				'rapot' => new ShowRaport($id,null, [new ShowRaporHeader('','','','',[])])
			]);
		}
		$query = "SELECT rh.id as rapor_header_id, semester, grade, tahun_ajaran FROM rapor_headers rh  
		WHERE rh.rapor_id = " . $raport->rapor_id;

		$rapor_header = DB::select($query);


		$raport_bundle_content = [];

		foreach ($rapor_header as $header) {
			$query = "SELECT nama_mata_pelajaran, nilai_uts, nilai_uas, catatan 
						FROM mata_pelajarans mp
							WHERE mp.rapor_header_id = " . $header->rapor_header_id;

			$datas = DB::select($query);

			$factory = new ShowRaporHeader(
				$header->rapor_header_id,
				$header->semester,
				$header->grade,
				$header->tahun_ajaran,
				$datas
			);

			array_push($raport_bundle_content, $factory);
		}


		$rapot = new ShowRaport(
			$raport->student_id,
			$raport->rapor_id,
			$raport_bundle_content
		);

		return view('/internal/DaftarNilaiSiswa', [
			'rapot' => $rapot
		]);
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
			->join('raports as r', 'rh.rapor_id', '=', 'r.id')
			->join('tbl_students as tb', 'r.student_id', '=', 'tb.id')
			->where('tb.id', '=', $student_Id->id)
			->get()
			->first();



		// $KelasSemester = ($current_Date->semester);


		if ($student_Id == null) {
			Session::flash('error', 'Murid dengan id ' . $studentId . ' tidak ditemukan!');
			return redirect('/pelajaran/internal/ImportNilai');
		}


		$class = Kelas::find($student_Id->class_id);


		if ($class->grade  != $Grade) {
			Session::flash('error', 'Data nilai yang anda masukan untuk ' . $student_Id->nama . ' tidak valid Karena Gradenya beda! Silahkan cek kembali kelas murid dan nama file yang anda upload!');
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
			Session::put('new_raport_header', true);
		}




		Session::put('raport_header_id', $raport_header->id);
		// Session::put('rapor_header_id',$raport->id);

		$mata_pelajaran = new MataPelajaranImport();

		$data = Excel::import($mata_pelajaran, $request->file('select_file'));

		Session::forget('raport_header_id');
		Session::forget('new_raport_header');
		// Session::forget('rapor_header_id');

		Session::flash('success', 'Sukses memasukan nilai siswa!');

		return redirect('/pelajaran/internal/ImportNilai');
	}


	public function IndexImportNilai()
	{
		return view('/internal/ImportNilai');
	}



	public function exportNilai($id,Request $request)
	{
		try {
			$exe = new MataPelajaranExport($request->id);
			$data = $exe->query();

			return Excel::download(new MappingRapot($data), "RAPORT SISWA"."_".date('Y-m-d H:i:s').".xlsx");

		} catch(Exception $ex) {
			print_r($ex->getMessage());
		}

	}
}

class ShowRaport
{
	public $student_id;
	public $rapor_id;
	public $raport_headers;

	public function __construct($a, $b, $c)
	{
		$this->student_id = $a;
		$this->rapor_id = $b;
		$this->raport_headers = $c;
	}
}

class ShowRaporHeader
{
	public $rapor_header_id;
	public $semester;
	public $grade;
	public $tahun_ajaran;
	public $mata_pelajarans;

	public function __construct($a, $b, $c, $d, $e)
	{
		$this->rapor_header_id = $a;
		$this->semester = $b;
		$this->grade = $c;
		$this->tahun_ajaran = $d;
		$this->mata_pelajarans = $e;
	}
}
