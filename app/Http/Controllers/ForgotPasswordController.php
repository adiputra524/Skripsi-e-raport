<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use App\SchoolInternal;
use App\TblStudent;


class ForgotPasswordController extends Controller
{
	public function forgot(){
		return view('forgot-password');
	}

	public function password(Request $request){
			if($request->isMethod('post')){
				$data = $request->all();
			//Get User Details
			$userDetails = SchoolInternal::where('email', $data['email']) -> first();

			//Generate Random Password
			 $random_password = Str::random(8);

			//Encode/Secure Password
			 $new_password = bcrypt($random_password);

			//Update Paasword
			SchoolInternal::where('email', $data['email']) -> update(['password' => $new_password]);

			//Send Forgot Password Email Code
			 $email = $data['email'];
			 $name = $userDetails->name;
			 $messageData = [
			 	'email' => $email,
			 	'name' => $name,
			 	'password' => $random_password
			 ];
			 Mail::send('email.forgotpassword', $messageData, function($message) use($email){
			 		$message->to($email) -> subject('New Password');
			 });		
			 	return redirect('/auth/LoginPage') -> with('success','Tolong cek email anda untuk melihat password baru');
			}	
		}
	
	public function forgotStudent(){
		return view('forgot-password-student');
	}

	public function passwordStudent(Request $request){
		if($request->isMethod('post')){
				$data = $request->all();
			//Get User Details
			$userDetails = TblStudent::where('email', $data['email']) -> first();

			//Generate Random Password
			 $random_password = Str::random(8);

			//Encode/Secure Password
			 $new_password = bcrypt($random_password);

			//Update Paasword
			TblStudent::where('email', $data['email']) -> update(['password' => $new_password]);

			//Send Forgot Password Email Code
			 $email = $data['email'];
			 $nama = $userDetails->nama;
			 $messageData = [
			 	'email' => $email,
			 	'nama' => $nama,
			 	'password' => $random_password
			 ];
			 Mail::send('email.forgotpasswordStudent', $messageData, function($message) use($email){
			 		$message->to($email) -> subject('New Password');
			 });		
			 	return redirect('/auth/LoginPage') -> with('success', 'Tolong cek email anda untuk melihat password baru');
			}
	}
}

