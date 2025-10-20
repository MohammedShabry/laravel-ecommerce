<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\SellerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
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
    public function store(Request $request, FlasherInterface $flasher): RedirectResponse
    {
        try {
            $request->validate([
                'name' => ['required','string','max:255'],
                'email' => ['required','string','email','max:255','unique:users,email'],
                // Enforce unique phone to prevent DB unique constraint violations
                'phone' => ['required', 'string', 'max:50', 'unique:users,phone', 'regex:/^\+?[0-9\s\-]{7,15}$/'],
                'country' => ['required','string','max:100'],
                'birthdate' => ['required','date'],
                'password' => ['required','confirmed', Rules\Password::defaults()],
                'role' => ['required','in:seller,customer'], // only seller/customer can register
            ]);

            // Create user - set users.status = 'active' for all registrations per requirement
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'status' => 'active',
            ]);

            // Persist profile data depending on role.
            // For sellers we create a SellerProfile with basic details (KYC will be done later).
            if ($user->role === 'seller') {
                SellerProfile::create([
                    'user_id' => $user->id,
                    'country' => $request->input('country'),
                    'birthdate' => $request->input('birthdate'),
                    'address' => $request->input('address'),
                ]);
            } else {
                // For customers, save details to user_profiles table
                UserProfile::create([
                    'user_id' => $user->id,
                    'country' => $request->input('country'),
                    'birthdate' => $request->input('birthdate'),
                    'address' => $request->input('address'),
                ]);
            }

            event(new Registered($user));

            Auth::login($user);

            // Success message
            $flasher->addSuccess('Registration successful. Welcome!');

            // Redirect based on role
            if ($user->role === 'seller') {
                // send sellers to KYC page so they submit required documents
                return redirect()->route('seller.kyc');
            } else {
                return redirect()->route('customer.home');
            }


        } catch (ValidationException $e) {
            // If any required fields are missing, show a single generic error message
            // to avoid showing one error per missing field. For other common
            // validation failures we add specific, friendly toasts (email, phone,
            // password confirmation) and fall back to showing any other errors.
            $failed = $e->validator->failed();
            $hasRequired = false;
            foreach ($failed as $fieldRules) {
                if (isset($fieldRules['Required'])) {
                    $hasRequired = true;
                    break;
                }
            }

            if ($hasRequired) {
                $flasher->addError('Please fill in all required fields.');
                return redirect()->back()->withInput();
            }

            // Check for specific rule failures to provide clearer toasts.
            $errors = $e->validator->errors();

            // Password confirmation mismatch
            if ($errors->has('password') && collect($errors->get('password'))->contains(function ($msg) {
                return Str::contains(strtolower($msg), 'confirmed') || Str::contains(strtolower($msg), 'confirmation');
            })) {
                $flasher->addError('Password and confirmation do not match.');
            }

            // Email validation errors (invalid format or already taken)
            if ($errors->has('email')) {
                $emailMsgs = $errors->get('email');
                foreach ($emailMsgs as $m) {
                    $low = strtolower($m);
                    if (Str::contains($low, 'unique') || Str::contains($low, 'taken')) {
                        $flasher->addError('That email address is already registered.');
                        // break to avoid duplicate toasts for multiple email messages
                        break;
                    }

                    if (Str::contains($low, 'valid') || Str::contains($low, 'email')) {
                        $flasher->addError('Please enter a valid email address.');
                        break;
                    }
                }
            }

            // Phone validation errors (including unique constraint)
            if ($errors->has('phone')) {
                $phoneMsgs = $errors->get('phone');
                foreach ($phoneMsgs as $m) {
                    $low = strtolower($m);
                    if (Str::contains($low, 'unique') || Str::contains($low, 'taken')) {
                        $flasher->addError('That phone number is already registered.');
                        // break out after showing the unique message
                        break;
                    }
                    // fall back to generic phone message
                    $flasher->addError('Please enter a valid phone number.');
                    break;
                }
            }

            // Add any remaining error messages that haven't been covered above
            $covered = ['password', 'email', 'phone'];
            foreach ($errors->all() as $err) {
                $lower = strtolower($err);
                $isCovered = false;
                foreach ($covered as $c) {
                    if (Str::contains($lower, $c)) {
                        $isCovered = true;
                        break;
                    }
                }
                if (! $isCovered) {
                    $flasher->addError($err);
                }
            }

            return redirect()->back()->withInput();

        } catch (\Exception $e) {
            // Log exception and show a helpful message in debug mode so real error is visible during development.
            // We keep the generic user-facing message in production for security.
            report($e);

            try {
                // Log full exception context
                \Log::error('Registration exception', ['exception' => $e]);
            } catch (\Throwable $logEx) {
                // ignore logging errors
            }

            if (config('app.debug')) {
                // In local/dev, include the exception message to help debugging
                $flasher->addError('An unexpected error occurred while registering: ' . $e->getMessage());
            } else {
                $flasher->addError('An unexpected error occurred while registering. Please try again.');
            }

            return redirect()->back()->withInput();
        }
    }
}
