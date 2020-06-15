<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TblStudent;
use App\Kelas;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Imports\TblStudentImport;
use Maatwebsite\Excel\Facades\Excel;
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



public function storeSiswa(Request $request)
{  
  $student = new TblStudentImport();
  $data = Excel::import($student ,$request->file('select_file'));

  return redirect('/student/internal/inputSiswa')->with('success','Data Siswa Telah Masuk');
}



public function editSiswa($id)
{
  $tbl_students = TblStudent::find($id);
  return view('',['' => $tbl_students]);
}

public function updateSiswa($id, Request $request)
{
  $this->validate($request,[
    'nama' =>'required',
    'nis' => 'required',
    'email' => 'required',
    'password' => 'required',
    'phone' => 'required',
    'class_id' => 'required'



  ]);


  $tbl_students =  TblStudent::find($id);
  $tbl_students->nama = $request->nama;
  $tbl_students->nis=$request->nis;
  $tbl_students->email=$request->email;
  $tbl_students->password=$request->password;
  $tbl_students->phone= $request->phone;
  $tbl_students->class_id=$request->class_id;
  $tbl_students->save();
  return redirect('');


}

public function deleteSiswa($id)
{
  $tbl_students = TblStudent::find($id);
  $tbl_students->delete();
  return redirect('/student/internal/inputSiswa');
}





}
