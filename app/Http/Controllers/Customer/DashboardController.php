<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
	/**
	 * Show the customer dashboard.
	 */
	public function dashboard(Request $request)
	{
		if (view()->exists('customer.dashboard')) {
			return view('customer.dashboard');
		}

		// Fallback simple response if the view isn't present yet.
		return response('Customer dashboard (view not found).', 200);
	}
}

