<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\TblStudent;
use Session;
class ChangePasswordController extends Controller
{
	public function editChangePassword()
	{
		return view('/student/ChangePasswordSiswa');
	}

	public function update(Request $request)
	{ 
		if(strlen($request->get('new-password')) < 8){
			Session::flash('error', 'Password harus terdiri lebih dari 8 karakter!');
			return redirect()->back();
		}

		$student = Session::get('tbl_students');
		//Session pas login

		$student_password = TblStudent::find($student->id);
		//cari objeck  student berdasarkan id

		$student_password->password=Hash::make($request->get('new-password'));
		$student_password->save();
		
		Session::flash('success', 'Password anda berubah');
		return redirect('/password/Siswa/ChangePassword');
	}





}

