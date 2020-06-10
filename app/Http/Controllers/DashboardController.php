<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function IndexDashboard()
	{
		return view('internal/internal-dashboard');
	}

	

}
