<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SellerProfile;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register-choice'); // Shows choice between seller/customer
    }

    /**
     * Show registration form for sellers.
     */
    public function createSeller(): View
    {
        $role = 'seller';
        return view('auth.register_seller', compact('role'));
    }

    /**
     * Show registration form for customers.
     */
    public function createCustomer(): View
    {
        $role = 'customer';
        return view('auth.register_customer', compact('role'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email'],
            'phone' => ['nullable','string','max:50','unique:users,phone'],
            'address' => ['nullable','string','max:255'],
            'country' => ['nullable','string','max:100'],
            'birthdate' => ['nullable','date'],
            'password' => ['required','confirmed', Rules\Password::defaults()],
            'role' => ['required','in:seller,customer'], // only seller/customer can register
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->role === 'seller' ? 'pending' : 'active',
            
        ]);

        // Create related profile
        if ($user->role === 'seller') {
            SellerProfile::create([
                'user_id' => $user->id,
                'status' => 'pending', 
                'birthdate' => $request->input('birthdate'),
            ]);
        } else {
            // Save other non-auth details in the user_profiles table
            UserProfile::create([
                'user_id' => $user->id,
                'address_line1' => $request->input('address'),
                'country' => $request->input('country'),
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'seller') {
            // send sellers to their dashboard where we'll show a KYC reminder modal
            return redirect()->route('seller.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }
}
