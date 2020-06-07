<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function IndexDashboard()
	{
		return view('Dashboard');


	}

	public function HitungNilaiRataRataSiswa(Request $request)
	{

	}
}
