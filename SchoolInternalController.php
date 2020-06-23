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

	public function editWalikelas($id)
	{
		$walikelas = SchoolInternal::find($id);

		return view('/internal/EditDataWalikelas',compact('walikelas'));
	}

	public function updateWalikelas(Request $request, SchoolInternal $walikelas)
	{
		/*$this->validate($request,[
			'nama' => 'required',
			'email' => 'required',
			'phone' => 'required'

		]);



		$walikelas = SchoolInternal::find($id);
		$walikelas->nama = $request->nama;
		$walikelas->email = $request->email;
		$walikelas->phone = $request->phone;

		$walikelas->save();*/

		SchoolInternal::where('id', $walikelas->id)
		->update([
			'nama' => $request -> nama,
			'email' => $request -> email,
			'phone' => $request -> phone
		]);
		return redirect('/auth/internal/inputGuru')->with('data berhasil diubah');


	}



	public function deleteGuru($id)
	{
		$school_internal = SchoolInternal::find($id);
		$school_internal -> delete();
		return redirect('/auth/internal/inputGuru');
	}





	
}
