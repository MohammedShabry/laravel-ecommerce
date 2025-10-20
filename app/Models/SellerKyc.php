<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerKyc extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'seller_kyc';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'seller_id',
        'user_id', // added: link directly to users table
        'shop_name',
        'business_type',
        'business_description',
        'business_registration_number',
        'address_street',
        'address_city',
        'address_state',
        'address_postal',
        'bank_name',
        'account_holder_name',
        'account_number',
        'branch_name',
        'national_id_number',
        'id_proof_front',
        'id_proof_back',
        'additional_doc',
        'terms_agreed',
        'verification_status',
        'submitted_at',
        'rejection_reason',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'terms_agreed' => 'boolean',
        'submitted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the seller profile that owns this KYC record.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(SellerProfile::class, 'seller_id');
    }

    /**
     * Get the user that owns this KYC record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
