<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SchoolInternal;
use App\Role;

use Validator;
use Session;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Imports\SchoolInternalImport;
use Maatwebsite\Excel\Facades\Excel;
class SchoolInternalController extends Controller
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
			return redirect('auth/LoginPage');
		}

		$data = DB::table('school_internals')
		->where('email','=',$request->get('email'))
		->get()->first();

		if(!isset($data)){
			Session::flash('error','Autentikasi error! Cek kembali username dan kata sandi anda');
			return redirect('auth/LoginPage');
		}

		if(!Hash::check($request->get('password'),$data->password)){
			Session::flash('error','Kata sandi salah ! Cek kembali kata sandi anda!');
			return redirect('auth/LoginPage');
		}

		Session::put('school_internals',$data);
		return redirect('internal/internal-dashboard');
	}

	

	public function LogoutSchool()
	{

		Session::flush();
		return redirect('/auth/LoginPage');



	}

	public function IndexGetGuru()
	{
		$school_internal = SchoolInternal::all();
		$school_internal = DB::table('roles as r')
		->select('*')
		->join('school_internals','role_id','=','r.id')
		->where('role_id','!=','1')
		->get();



		return view('/internal/inputGuru',compact('school_internal'));
	}

	public function storeGuru(Request $request)
	{
		$guru = new SchoolInternalImport();
		$data = Excel::import($guru,$request->file('select_file')); 

		return redirect('/auth/internal/inputGuru')->with('success','Data Siswa Telah Masuk');
	}

	public function editSiswa($id)
	{
		$school_internal = SchoolInternal::find($id);
		return view('',['' => $school_internal ]);
	}

	public function updateSiswa($id, Request $request)
	{
		$this->validate($request,[
			'name' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'password' => 'required',
			'role_id' =>'required'
		]);

		$school_internal = SchoolInternal::find($id);
		$school_internal->name = $request->name;
		$school_internal->email = $request->email;
		$school_internal->phone = $request->phone;
		$school_internal->password = $request->password;
		$school_internal->role_id = $request->role_id;
		$school_internal->save();
		return redirect('');


	}

	public function deleteGuru($id)
	{
		$school_internal = SchoolInternal::find($id);
		$school_internal -> delete();
		return redirect('/auth/internal/inputGuru');
	}





	
}
