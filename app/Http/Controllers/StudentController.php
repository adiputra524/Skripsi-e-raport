<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TblStudent;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class StudentController extends Controller
{

  public function IndexLoginStudent(){
    return view('LoginStudent');



  }

  public function LoginStudent()
  {
   $validate = Validator::make($request->all(),[
    "email" =>'required',
    "password" => 'required'

  ]);

   if($validate->fails()){
    $error = $validate->errors()->first();

    Session::flash('error',$error);
    return redirect('LoginStudent');
  }

  $data = DB::table('tbl_students')
  ->where('email','=',$request->get('email'))
  ->get()->first();

  if(!isset($data)){
   Session::flash('error','Autentikasi error! Cek kembali username dan kata sandi anda');
   return redirect('LoginStudent');
 }

 if(!Hash::check($request->get('password'),$data->password)){
   Session::flash('error','Kata sandi salah ! Cek kembali kata sandi anda!');
   return redirect('LoginStudent');
 }


 Session::put('tbl_students',$data);
 return redirect('Welcome');

}

public function RegisterStudent(Request $request)
{


//  $this->validate($request,[
//   'nama' => 'required',
//   'nisn' => 'required',
//   'nis' => 'required',
//   'email'=> 'required|string|email|max:255|unique:users',
//   'password' => 'required|string|min:6|confirmed',
//   'phone' => 'required',
//   // 'profile_picture'=>'required'

// ]);

//  return TblStudent::create([
//   'nama' => $request->nama,
//   'nisn' => $request->nisn,
//   'nis' =>$request->nis,
//   'email' => $request->email,
//   'password' => Hash::make($request['password']),
//   'phone' => $request->phone
//   // 'profile_picture' =>$request->profile_picture


// ]);

 $tbl_students = TblStudent::create([
  'nama' => $request->nama,
  'nisn' => $request->nisn,
  'nis' =>$request->nis,
  'email' => $request->email,
  'password' => Hash::make($request['password']),
  'phone' => $request->phone

 ]);

 dd($tbl_students);

 // return redirect('/');




}

public function  LogoutStudent()
{
 Session::flush();
 return redirect('/');




}



}
