<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TblStudent;
use App\Kelas;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
class StudentController extends Controller
{

  public function IndexLoginStudent(){
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

// public function RegisterStudent(Request $request)
// {


// //  $this->validate($request,[
// //   'nama' => 'required',
// //   'nisn' => 'required',
// //   'nis' => 'required',
// //   'email'=> 'required|string|email|max:255|unique:users',
// //   'password' => 'required|string|min:6|confirmed',
// //   'phone' => 'required',
// //   // 'profile_picture'=>'required'

// // ]);

// //  return TblStudent::create([
// //   'nama' => $request->nama,
// //   'nisn' => $request->nisn,
// //   'nis' =>$request->nis,
// //   'email' => $request->email,
// //   'password' => Hash::make($request['password']),
// //   'phone' => $request->phone
// //   // 'profile_picture' =>$request->profile_picture


// // ]);

//  // $tbl_students = TblStudent::create([
//  //  'nama' => $request->nama,
//  //  'nisn' => $request->nisn,
//  //  'nis' =>$request->nis,
//  //  'email' => $request->email,
//  //  'password' => Hash::make($request['password']),
//  //  'phone' => $request->phone

//  // ]);

//  // dd($tbl_students);

//  // // return redirect('/');




// }

public function  LogoutStudent()
{
 Session::flush();
 return redirect('/student/LoginStudent');




}

  public function IndexGetStudent()
    {
        $student = TblStudent::all();
        return view('',[''=>$student]);
    }

    public function tambahStudent()
    {
        return view('');
    }

    public function storeStudent(Request $request)
    {
      $this->validate($request,[
        'nama' =>'required',
        'nis' => 'required',
        'email' => 'required',
        'password' => 'required',
        'phone' => 'required',
        'class_id' => 'required'



      ]);

      TblStudent::create([
        'nama' => $request->nama,
        'nis' => $request->nis,
        'email' => $request->email,
        'password' => $request->password,
        'phone' => $request->phone,
        'class_id' => $request->class_id

      ]);

      return redirect('');
    }



    public function editStudent($id)
    {
      $tbl_students = TblStudent::find($id);
      return view('',['' => $tbl_students]);
    }

    public function updateStudent($id, Request $request)
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
      $tbl_students->nama = $request->class_name;
      $tbl_students->nis=$request->nis;
      $tbl_students->email=$request->email;
      $tbl_students->password=$request->password;
      $tbl_students->phone= $request->phone;
      $tbl_students->class_id=$request->class_id;
      $tbl_students->save();
      return redirect('');


    }

    public function deleteStudent($id)
    {
      $tbl_students = TblStudent::find($id);
      $tbl_students->delete();
      return redirect('');
    }

    // public function JoinTableStudent()
    // {
    //   $tbl_students =DB::table('tbl_students'
    //     ->join('kelas','tbl_students.class_id','=','kelas.id'))
    //   ->get();

    //   dd($tbl_students);

    // }





}
