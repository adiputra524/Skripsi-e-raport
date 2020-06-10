<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardSiswaController extends Controller
{
    public function IndexDashboardSiswa()
	{
		return view('student/student-view');
	}
}
