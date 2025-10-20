<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seller_kyc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('seller_profiles')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // 1. Business Information
            $table->string('shop_name');
            $table->string('business_type')->nullable();
            $table->text('business_description')->nullable();
            $table->string('business_registration_number')->nullable();

            // 2. Business Address
            $table->string('address_street')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_postal')->nullable();

            // 3. Bank Account Details
            $table->string('bank_name');
            $table->string('account_holder_name');
            $table->string('account_number');
            $table->string('branch_name')->nullable();

            // 4. Identity Verification
            $table->string('national_id_number');
            $table->string('id_proof_front'); // file path
            $table->string('id_proof_back')->nullable(); // optional
            $table->string('additional_doc')->nullable();

            // Other Info
            $table->boolean('terms_agreed')->default(false);
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('submitted_at')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_kyc');
    }
};
