<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show seller dashboard. If the seller has no KYC, the view will show a warning
     * and include a modal form.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $sellerProfile = $user->sellerProfile ?? $user->profile ?? null;

        // Determine if KYC exists
        $hasKyc = false;
        if ($sellerProfile && method_exists($sellerProfile, 'kyc')) {
            $hasKyc = (bool) $sellerProfile->kyc()->exists();
        }

        return view('seller.dashboard', [
            'user' => $user,
            'hasKyc' => $hasKyc,
        ]);
    }

    /** Placeholder: previous routes used this for separate KYC form. Keep for compatibility. */
    public function kycForm()
    {
        return redirect()->route('seller.dashboard');
    }

    public function submitKyc(Request $request)
    {
        // Delegate to KycController for handling; kept here for route compatibility in case
        return app(KycController::class)->submit($request);
    }
}
