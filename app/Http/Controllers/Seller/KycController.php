<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerKyc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class KycController extends Controller
{
    public function submit(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'shop_name' => ['required','string','max:255'],
            'business_type' => ['nullable','string','max:255'],
            'business_description' => ['nullable','string'],
            'business_registration_number' => ['nullable','string','max:255'],

            'address_street' => ['nullable','string','max:255'],
            'address_city' => ['nullable','string','max:255'],
            'address_state' => ['nullable','string','max:255'],
            'address_postal' => ['nullable','string','max:100'],

            'national_id_number' => ['required','string','max:255'],
            'bank_name' => ['required','string','max:255'],
            'account_holder_name' => ['required','string','max:255'],
            'account_number' => ['required','string','max:100'],
            'branch_name' => ['nullable','string','max:255'],
            // 'bank_code' removed

            'id_proof_front' => ['required','file'],
            'id_proof_back' => ['nullable','file'],
            'additional_doc' => ['nullable','file'],

            'terms_agreed' => ['accepted'],
        ]);

        // ensure seller profile exists (minimal fields from blade)
        $sellerProfile = $user->sellerProfile;
        if (! $sellerProfile) {
            $sellerProfile = $user->sellerProfile()->create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        } else {
            // mark as pending when user (re)submits KYC
            $sellerProfile->update([
                'status' => 'pending',
            ]);
        }

        // helper to store uploaded file and return the path
        $upload = function ($file) use ($user) {
            return $file->store("seller_kyc/{$user->id}", 'public');
        };

        // prepare data for create/update without overwriting file fields with null
        $kycData = [
            // link explicitly to user and seller profile so checks can find the record
            'user_id' => $user->id,
            'seller_id' => $sellerProfile->id,

            // Business Info
            'shop_name' => $request->input('shop_name'),
            'business_type' => $request->input('business_type'),
            'business_description' => $request->input('business_description'),
            'business_registration_number' => $request->input('business_registration_number'),

            // Address
            'address_street' => $request->input('address_street'),
            'address_city' => $request->input('address_city'),
            'address_state' => $request->input('address_state'),
            'address_postal' => $request->input('address_postal'),

            // Bank & ID
            'bank_name' => $request->input('bank_name'),
            'account_holder_name' => $request->input('account_holder_name'),
            'account_number' => $request->input('account_number'),
            'branch_name' => $request->input('branch_name'),
            'national_id_number' => $request->input('national_id_number'),

            'terms_agreed' => (bool) $request->has('terms_agreed'),
            'verification_status' => 'pending',
            'submitted_at' => now(),
        ];

        // find existing KYC to allow safe replace of files
        $existing = SellerKyc::where('seller_id', $sellerProfile->id)->first();

        // handle id_proof_front (required in this form)
        if ($request->hasFile('id_proof_front')) {
            $newPath = $upload($request->file('id_proof_front'));
            // delete old file if present
            if ($existing && $existing->id_proof_front) {
                Storage::disk('public')->delete($existing->id_proof_front);
            }
            $kycData['id_proof_front'] = $newPath;
        } elseif ($existing) {
            // keep existing path if no new upload
            $kycData['id_proof_front'] = $existing->id_proof_front;
        }

        // optional id_proof_back
        if ($request->hasFile('id_proof_back')) {
            $newBack = $upload($request->file('id_proof_back'));
            if ($existing && $existing->id_proof_back) {
                Storage::disk('public')->delete($existing->id_proof_back);
            }
            $kycData['id_proof_back'] = $newBack;
        } elseif ($existing) {
            $kycData['id_proof_back'] = $existing->id_proof_back;
        }

        // optional additional_doc
        if ($request->hasFile('additional_doc')) {
            $newDoc = $upload($request->file('additional_doc'));
            if ($existing && $existing->additional_doc) {
                Storage::disk('public')->delete($existing->additional_doc);
            }
            $kycData['additional_doc'] = $newDoc;
        } elseif ($existing) {
            $kycData['additional_doc'] = $existing->additional_doc;
        }

        $kyc = SellerKyc::updateOrCreate(
            ['seller_id' => $sellerProfile->id],
            $kycData
        );

        // After submission we keep the seller on the KYC page until an admin approves their documents.
        return redirect()->route('seller.kyc')->with('status', 'KYC submitted and is under review');
    }
}
