<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SchoolInternal;
use Validator;
use Session;
use Illuminate\Support\Facades\Hash;
use DB;
class LoginSchoolController extends Controller
{
	public function IndexLogin(){
		return view('Login');



	}
	public function LoginSchool(Request $request)
	{

		$validate = Validator::make($request->all(),[
			"email" =>'required',
			"password" => 'required'

		]);

		if($validate->fails()){
			$error = $validate->errors()->first();

			Session::flash('error',$error);
			return redirect('auth/Login');
		}

		$data = DB::table('school_internals')
		->where('email','=',$request->get('email'))
		->get()->first();

		if(!isset($data)){
			Session::flash('error','Autentikasi error! Cek kembali username dan kata sandi anda');
			return redirect('auth/Login');
		}

		if(!Hash::check($request->get('password'),$data->password)){
			Session::flash('error','Kata sandi salah ! Cek kembali kata sandi anda!');
			return redirect('auth/Login');
		}

		Session::put('school_internals',$data);
		return redirect('Dashboard');
		


	}

	// public function RegisterSchool()
	// {

	// 	$this->validate($request,[
	// 		'nama' => 'required',
	// 		'email'=> 'required|string|email|max:255|unique:users',
	// 		'phone' => 'required',
	// 		'password' => 'required|string|min:6|confirmed',
	// 		'profile_picture'=>'required',
	// 		'role_id' =>'required'

	// 	]);

	// 	return SchoolInternal::create([
	// 		'nama' => $request->nama,
	// 		'email' => $request->email,
	// 		'password' => Hash::make($request['password']),
	// 		'phone' => $request->phone,
	// 		'profile_picture' =>$request->profile_picture,
	// 		'role_id' => $request->role_id


	// 	]);

	// 	return redirec('/masuk ke dashboard');



	// }

	public function LogoutSchool()
	{

		Session::flush();
		return redirect('/auth/LoginPage');



	}
}
