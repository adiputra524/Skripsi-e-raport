<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\TblStudent;

class ChangePasswordController extends Controller
{
	public function editChangePassword()
	{
		return view('/student/ChangePasswordSiswa');
	}

	public function update(ChangePasswordRequest $request)
	{
		$request->TblStudent()->update([
			'password' => Hash::make($request->get('password'))

		]);
	return redirect('student/ChangePasswordSiswa');

	}





}

