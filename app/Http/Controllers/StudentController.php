<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TblStudent;
use App\SchoolInternal;
use App\Kelas;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Imports\TblStudentImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mata_pelajaran;
use App\Rapor_header;
use App\Raport;

class StudentController extends Controller
{

  public function IndexLoginStudent()
  {
    return view('/student/LoginSiswa-view');
  }

  public function LoginStudent(Request $request)
  {
    $validate = Validator::make($request->all(), [
      "email" => 'required',
      "password" => 'required'
    ]);

    if ($validate->fails()) {
      $error = $validate->errors()->first();

      Session::flash('error', $error);
      return redirect('/student/LoginStudent');
    }

    $data = DB::table('tbl_students')
      ->where('email', '=', $request->get('email'))
      ->get()->first();

    if (!isset($data)) {
      Session::flash('error', 'Autentikasi error! Cek kembali username dan kata sandi anda');
      return redirect('/student/LoginStudent');
    }

    if (!Hash::check($request->get('password'), $data->password)) {
      Session::flash('error', 'Kata sandi salah ! Cek kembali kata sandi anda!');
      return redirect('/student/LoginStudent');
    }


    Session::put('tbl_students', $data);
    Session::put('class', Kelas::all());
    return redirect('/student/student-view');
  }

  public function  LogoutStudent()
  {
    Session::flush();
    return redirect('/student/LoginStudent');
  }

  public function IndexGetSiswa()
  {
    $tbl_student = TblStudent::all();
    $tbl_student = DB::table('kelas AS k')
      ->select('*')
      ->join('tbl_students', 'class_id', '=', 'k.id')
      ->get();

    return view('/internal/inputSiswa', compact('tbl_student'));
  }


  public function DataSiswa($kelas)
  {
    $tbl_student = TblStudent::all();
    $tbl_student = DB::table('kelas AS k')
      ->select('*')
      ->join('tbl_students', 'class_id', '=', 'k.id')
      ->where('class_id', '=', $kelas)
      ->get();

    return view('/internal/DaftarSiswaPerKelas', compact('tbl_student'));
  }

  public function getDataWalikelas(Request $request)
  {

    $school_internal = SchoolInternal::all();
    $school_internal = DB::table('roles as r')
      ->select('*')
      ->join('school_internals', 'role_id', '=', 'r.id')
      ->where('role_id', '!=', '1')
      ->get();



    return view('/student/DataWaliKelas', compact('school_internal'));
  }

  public function IndexNilaiSiswa($id)
  {

    $raport = DB::table('raports as r')
    ->select('r.student_id', 'r.id as rapor_id')
    ->where('r.student_id', '=', $id)
    ->get()
    ->first();

    if ($raport == null) {
      return view('/internal/DaftarNilaiSiswa', [
        'rapot' => new ShowRaport($id, null, [new ShowRaporHeader('', '', '', '', [])])
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
    // dd($raport);
    return view('/student/NilaiSiswa', [
      'rapot' => $rapot
    ]);
    // return view('/student/NilaiSiswa', compact('raport'));
  }


  public function storeSiswa(Request $request)
  {
    $student = new TblStudentImport();
    $data = Excel::import($student, $request->file('select_file'));

    return redirect('/student/internal/inputSiswa')->with('success', 'Data Siswa Telah Masuk');
  }




  public function editSiswa($id)
  {
    $students = TblStudent::find($id);

    return view('/internal/EditDataSiswa', compact('students'));
  }

  public function updateSiswa(Request $request, $id)
  {
    $this->validate($request, [
      'nis' => 'required',
      'nama' => 'required',
      'class_id' => 'required',
      'email' => 'required',
      'phone' => 'required'

    ]);



    $students = TblStudent::find($id);
    $students->nis = $request->nis;
    $students->nama = $request->nama;
    $students->class_id = $request->class_id;
    $students->email = $request->email;
    $students->phone = $request->phone;

    $students->save();

    return redirect('/student/internal/inputSiswa')->with('data berhasil diubah');
  }

  public function deleteSiswa($id)
  {
    TblStudent::where('id', $id)->delete();
    // $tbl_students = TblStudent::find($id);
    // $tbl_students->delete();
    return redirect('/student/internal/inputSiswa');
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
