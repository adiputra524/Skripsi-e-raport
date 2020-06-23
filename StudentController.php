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
   $validate = Validator::make($request->all(),[
    "email" =>'required',
    "password" => 'required'

  ]);

   if($validate->fails()){
    $error = $validate->errors()->first();

    Session::flash('error',$error);
    return redirect('/student/LoginStudent');
  }

  $data = DB::table('tbl_students')
  ->where('email','=',$request->get('email'))
  ->get()->first();

  if(!isset($data)){
   Session::flash('error','Autentikasi error! Cek kembali username dan kata sandi anda');
   return redirect('/student/LoginStudent');
 }

 if(!Hash::check($request->get('password'),$data->password)){
   Session::flash('error','Kata sandi salah ! Cek kembali kata sandi anda!');
   return redirect('/student/LoginStudent');
 }


 Session::put('tbl_students',$data);
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
  $tbl_student=DB::table('kelas AS k')
  ->select('*')
  ->join('tbl_students','class_id','=','k.id')
  ->get();

  return view('/internal/inputSiswa',compact('tbl_student'));
}


public function DataSiswaKelas10()
{
  $tbl_student = TblStudent::all();
  $tbl_student=DB::table('kelas AS k')
  ->select('*')
  ->join('tbl_students','class_id','=','k.id')
  ->where('class_id','!=','3') 
  ->where('class_id','!=','4') 
  ->get();

  return view('/internal/DaftarSiswaKelas10',compact('tbl_student'));
}

public function DataSiswaKelas11()
{
  $tbl_student = TblStudent::all();
  $tbl_student=DB::table('kelas AS k')
  ->select('*')
  ->join('tbl_students','class_id','=','k.id')
  ->where('class_id','!=','1') 
  ->where('class_id','!=','4') 
  ->get();

  return view('/internal/DaftarSiswaKelas11',compact('tbl_student'));
}

public function DataSiswaKelas12()
{
  $tbl_student = TblStudent::all();
  $tbl_student=DB::table('kelas AS k')
  ->select('*')
  ->join('tbl_students','class_id','=','k.id')
  ->where('class_id','!=','1') 
  ->where('class_id','!=','3') 
  ->get();

  return view('/internal/DaftarSiswaKelas12',compact('tbl_student'));
}

public function getDataWalikelas(Request $request)
{

  $school_internal = SchoolInternal::all();
  $school_internal = DB::table('roles as r')
  ->select('*')
  ->join('school_internals','role_id','=','r.id')
  ->where('role_id','!=','1')
  ->get();



  return view('/student/DataWaliKelas',compact('school_internal'));
}

public function getNilaiSiswaKelas10(Request $request)
{
  $mata_pelajaran = Mata_pelajaran::all();
  $mata_pelajaran = DB::table('rapor_headers as rh')
  ->select('*')
  ->join('mata_pelajarans','rapor_header_id','=','rh.id')
  ->get();

  return view('/student/NilaiSiswaKelas10',compact('mata_pelajaran'));


}

public function getNilaiSiswaKelas11(Request $request)
{
  $mata_pelajaran = Mata_pelajaran::all();
  $mata_pelajaran = DB::table('rapor_headers as rh')
  ->select('*')
  ->join('mata_pelajarans','rapor_header_id','=','rh.id')
  ->get();

  return view('/student/NilaiSiswaKelas11',compact('mata_pelajaran'));


}

public function getNilaiSiswaKelas12(Request $request)
{
  $mata_pelajaran = Mata_pelajaran::all();
  $mata_pelajaran = DB::table('rapor_headers as rh')
  ->select('*')
  ->join('mata_pelajarans','rapor_header_id','=','rh.id')
  ->get();

  return view('/student/NilaiSiswaKelas12',compact('mata_pelajaran'));


}




public function storeSiswa(Request $request)
{  
  $student = new TblStudentImport();
  $data = Excel::import($student ,$request->file('select_file'));

  return redirect('/student/internal/inputSiswa')->with('success','Data Siswa Telah Masuk');
}




public function editSiswa($id)
{
  $students = TblStudent::find($id);

  return view('/internal/EditDataSiswa',compact('students'));
}

public function updateSiswa(Request $request, TblStudent $students)
{
  /*$this->validate($request,[
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

  $students->save();*/

  Tbl_student::where('id', $students->id)
    ->update([
      'nis' => $request -> nis,
      'nama' => $request -> nama,
      'class_id' => $request -> class_id,
      'email' => $request -> email,
      'phone' => $request -> phone
    ]);

  return redirect('/student/internal/inputSiswa')->with('data berhasil diubah');


}

public function deleteSiswa($id)
{
  $tbl_students = TblStudent::find($id);
  $tbl_students->delete();
  return redirect('/student/internal/inputSiswa');
}






}
