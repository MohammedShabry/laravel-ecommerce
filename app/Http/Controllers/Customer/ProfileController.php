<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Update authenticated customer's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            // allow partial updates: use 'sometimes' so shipping-only form can submit without name/email
            'name' => ['sometimes','required','string','max:255'],
            'email' => ['sometimes','required','email','max:255'],
            'phone' => ['sometimes','nullable','string','max:50'],
            'birthdate' => ['nullable','date'],
            'profile_image' => ['nullable','image','max:2048'],
            // Address fields
            'country' => ['nullable','string','max:100'],
            'address_street' => ['nullable','string','max:255'],
            'address_city' => ['nullable','string','max:100'],
            'address_state' => ['nullable','string','max:100'],
            'address_postal' => ['nullable','string','max:50'],
        ]);

        // Update core user fields only when provided to avoid overwriting on partial updates
        $dirty = false;
        if ($request->has('name')) {
            $user->name = $request->input('name');
            $dirty = true;
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
            $dirty = true;
        }
        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
            $dirty = true;
        }
        if ($dirty) {
            $user->save();
        }

        // Ensure profile exists
        $profile = $user->profile;
        if (!$profile) {
            $profile = $user->profile()->create([]);
        }

        $profile->birthdate = $request->input('birthdate') ?: null;

        // save address fields to profile (if provided)
        // If the incoming value is empty string, we allow it to set as null/empty by using null coalescing only when not provided at all
        if ($request->has('country')) {
            $profile->country = $request->input('country') ?: null;
        }
        if ($request->has('address_street')) {
            $profile->address_street = $request->input('address_street') ?: null;
        }
        if ($request->has('address_city')) {
            $profile->address_city = $request->input('address_city') ?: null;
        }
        if ($request->has('address_state')) {
            $profile->address_state = $request->input('address_state') ?: null;
        }
        if ($request->has('address_postal')) {
            $profile->address_postal = $request->input('address_postal') ?: null;
        }

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $path = $file->store('profile_images', 'public');

            // delete old image if present
            if ($profile->profile_image && Storage::disk('public')->exists($profile->profile_image)) {
                Storage::disk('public')->delete($profile->profile_image);
            }

            $profile->profile_image = $path;
        }

        $profile->save();

        return back()->with('status', 'Profile updated successfully.');
    }
}
