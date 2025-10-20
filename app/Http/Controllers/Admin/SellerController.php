<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerProfile;
use App\Models\SellerKyc;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{

    public function index(Request $request)
    {
        $sellers = SellerProfile::with('user')->orderBy('created_at','desc')->paginate(30);
        return view('admin.sellerlist', [
            'sellers' => $sellers,
        ]);
    }

    /**
     * Show a single seller's details page.
     *
     * @param Request $request
     * @param int $sellerId
     */
    public function show(Request $request, $sellerId)
    {
        // load seller profile with user and kyc if needed
        $seller = SellerProfile::with('user','kyc')->findOrFail($sellerId);

        return view('admin.sellerdetails', [
            'seller' => $seller,
        ]);
    }

    // show KYC requests (profiles with pending KYC)
    public function requests(Request $request)
    {
        // join seller_profiles -> seller_kyc where verification_status = 'pending'
        $kycs = SellerKyc::with('seller','user')
            ->where('verification_status','pending')
            ->orderBy('submitted_at','desc')
            ->get();

        return view('admin.sellerrequests', [
            'kycs' => $kycs,
        ]);
    }

    // approve KYC -> set verification_status = approved and seller_profiles.status = active
    public function accept(Request $request, $sellerId)
    {
        DB::transaction(function () use ($sellerId) {
            $kyc = SellerKyc::where('seller_id',$sellerId)->first();
            if ($kyc) {
                $kyc->update(['verification_status' => 'approved']);
            }
            $profile = SellerProfile::find($sellerId);
            if ($profile) {
                // copy certain fields from KYC into the seller profile so store info is populated
                // note: the seller_profiles table uses `verification_status`, not `status`
                $update = [
                    'verification_status' => 'active',
                ];

                if ($kyc) {
                    // map KYC fields -> profile fields when present
                    if (!empty($kyc->shop_name)) {
                        $update['store_name'] = $kyc->shop_name;
                    }
                    if (isset($kyc->business_description)) {
                        $update['store_description'] = $kyc->business_description;
                    }
                    if (isset($kyc->address_street)) {
                        $update['address_street'] = $kyc->address_street;
                    }
                    if (isset($kyc->address_city)) {
                        $update['address_city'] = $kyc->address_city;
                    }
                    if (isset($kyc->address_state)) {
                        $update['address_state'] = $kyc->address_state;
                    }
                    if (isset($kyc->address_postal)) {
                        $update['address_postal'] = $kyc->address_postal;
                    }
                }

                $profile->update($update);
            }
        });

        return redirect()->back()->with('status','Seller KYC approved');
    }

    // reject KYC -> set verification_status = rejected and leave seller_profiles.status as pending or set to 'inactive'
    public function reject(Request $request, $sellerId)
    {
        // support both `reason` (existing) and `rejection_reason` (AJAX flow)
        $request->validate([
            'reason' => ['nullable','string'],
            'rejection_reason' => ['nullable','string'],
        ]);

        DB::transaction(function () use ($sellerId, $request) {
            $kyc = SellerKyc::where('seller_id',$sellerId)->first();
            if ($kyc) {
                // prefer explicit rejection_reason (sent by AJAX), fallback to reason
                $reason = $request->input('rejection_reason', $request->input('reason'));
                $kyc->update([
                    'verification_status' => 'rejected',
                    'rejection_reason' => $reason,
                ]);
            }
            $profile = SellerProfile::find($sellerId);
            if ($profile) {
                // set profile verification_status to pending when a KYC is rejected
                $profile->update(['verification_status' => 'pending']);
            }
        });

        // If the request expects JSON (AJAX / fetch), return a JSON payload
        if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => true, 'message' => 'Seller KYC rejected']);
        }

        return redirect()->back()->with('status','Seller KYC rejected');
    }
}
