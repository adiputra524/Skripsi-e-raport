<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
class DashboardSiswaController extends Controller
{
    public function IndexDashboardSiswa()
	{
		return view('student/student-view');
	}
}
