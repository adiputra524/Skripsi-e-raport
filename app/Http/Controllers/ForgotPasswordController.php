<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ForgotPasswordController extends Controller
{
	public function resetPassword(Request $request);
	{


    //Validate input
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|exists:,email',
			'password' => 'required|confirmed'
			'token' => 'required' ]);

    //check if payload is valid before moving on
		if ($validator->fails()) {
			return redirect('\RegisterPage')->back()->withErrors(['email' => 'Please complete the form']);
		}

		$password = $request->password;
// Validate the token
		$tokenData = DB::table('password_resets')
		->where('token', $request->token)->first();
// Redirect the user back to the password reset request form if the token is invalid
		if (!$tokenData) return view('auth.passwords.email');

		$user = User::where('email', $tokenData->email)->first();
// Redirect the user back if the email is invalid
		if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);
//Hash and update the new password
		$user->password = \Hash::make($password);
    $user->update(); //or $user->save();

    //login the user immediately they change password successfully
    Auth::login($user);

    //Delete the token
    DB::table('password_resets')->where('email', $user->email)
    ->delete();

    //Send Email Reset Success Email
    if ($this->sendSuccessEmail($tokenData->email)) {
    	return view('index');
    } else {
    	return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
    }







}
}
