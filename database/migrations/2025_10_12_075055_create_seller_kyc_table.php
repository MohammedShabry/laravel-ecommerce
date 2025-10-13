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
            $table->string('business_registration_number')->nullable();
            $table->string('bank_name');
            $table->string('account_holder_name');
            $table->string('account_number');
            $table->string('branch_name')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('national_id_number');
            $table->string('id_proof_front'); // store file path
            $table->string('id_proof_back')->nullable(); // optional
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
