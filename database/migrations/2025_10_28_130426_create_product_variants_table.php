<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // FK to products
            $table->string('sku', 100)->unique();
            $table->string('color')->nullable(); // Optional color name (not an attribute)
            $table->string('color_code', 20)->nullable(); // Optional color code (hex or other)
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();
            $table->softDeletes(); // allow soft-deleting variants
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
