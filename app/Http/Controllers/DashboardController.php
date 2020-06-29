<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kelas;

class DashboardController extends Controller
{
	public function IndexDashboard()
	{
		return view('internal/internal-dashboard');
	}

	

}
