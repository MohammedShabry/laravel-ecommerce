<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\SellerProfile; // added: used to check existence of KYC record
use App\Models\SellerKyc; // added: require seller KYC record before allowing dashboard
use Flasher\Prime\FlasherInterface; // added: inject flasher to add toasts on login

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create(Request $request): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request, FlasherInterface $flasher): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect based on role
        if ($user->role === 'admin') {
            $flasher->addSuccess('Welcome back, admin!');
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'seller') {
            // Require sellers to submit KYC before accessing dashboard.
            $sellerProfile = SellerProfile::where('user_id', $user->id)->first();
            if (! $sellerProfile) {
                // profile not created yet -> send to KYC page (profile creation occurs when KYC is submitted)
                $flasher->addInfo('Please complete your seller profile and submit KYC to access the dashboard.');
                return redirect()->route('seller.kyc');
            }

            // Check for an actual KYC record linked to either seller_profile or user.
            $kyc = SellerKyc::where('seller_id', $sellerProfile->id)
                ->orWhere('user_id', $user->id)
                ->first();

            // Not submitted -> go to KYC page
            if (! $kyc) {
                $flasher->addInfo('Please submit your KYC documents to access the seller dashboard.');
                return redirect()->route('seller.kyc');
            }

            // Only allow dashboard when KYC is explicitly approved
            if ($kyc->verification_status !== 'approved') {
                // keep user on KYC page until admin approves
                $flasher->addWarning('Your KYC is pending approval. You will be notified once it is approved.');
                return redirect()->route('seller.kyc');
            }

            // Approved -> allow access to seller dashboard
            $flasher->addSuccess('Welcome back!');
            return redirect()->route('seller.dashboard');
        } else { // customer
            $flasher->addSuccess('Welcome back!');
            return redirect()->route('customer.home');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
