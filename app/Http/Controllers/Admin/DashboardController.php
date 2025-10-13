<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function dashboard(Request $request)
	{
		// Show the admin dashboard view. Keep this lightweight — the view can
		// render whatever admin metrics or controls are needed.
		$user = $request->user();
		return view('admin.dashboard', [
			'user' => $user,
		]);
	}
}
