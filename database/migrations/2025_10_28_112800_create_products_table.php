<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // id
            $table->string('name'); // Product name
            $table->string('slug')->unique(); // URL slug
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Main category
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null'); // Brand
            $table->foreignId('seller_id')->nullable()->constrained('users')->onDelete('set null'); // Owner / seller (nullable)
            $table->string('unit', 50)->nullable(); // Unit
            $table->decimal('weight', 8, 2)->nullable(); // Weight in kg
            $table->text('short_description')->nullable(); // Short description
            $table->text('description')->nullable(); // Full description
            $table->string('barcode', 100)->nullable(); // Barcode
            $table->boolean('refundable')->default(false); // Refundable toggle
            $table->text('refund_note')->nullable(); // Refund note
            $table->boolean('featured')->default(false); // Featured toggle
            $table->boolean('todays_deal')->default(false); // Today's deal toggle
            $table->boolean('flash_deal')->default(false); // Flash deal toggle
            $table->dateTime('flash_start')->nullable(); // Flash deal start
            $table->dateTime('flash_end')->nullable(); // Flash deal end
            $table->decimal('flash_discount', 10, 2)->nullable(); // Flash discount
            $table->enum('flash_discount_type', ['flat','percent'])->nullable(); // Flash discount type
            $table->decimal('discount', 10, 2)->nullable(); // General discount
            $table->enum('discount_type', ['flat','percent'])->nullable(); // General discount type
            $table->integer('low_stock_quantity')->default(0); // Low stock warning
            $table->enum('stock_visibility', ['quantity','text_only','hidden'])->default('quantity'); // Stock visibility
            $table->dateTime('published_at')->nullable();
            $table->string('meta_title')->nullable(); // SEO meta title
            $table->text('meta_description')->nullable(); // SEO meta description
            $table->text('meta_keywords')->nullable(); // SEO keywords
            $table->boolean('cash_on_delivery')->default(false); // Shipping: COD
            $table->boolean('free_shipping')->default(false); // Free shipping
            $table->boolean('flat_rate')->default(false); // Flat rate shipping
            $table->decimal('shipping_cost', 10, 2)->nullable(); // Flat rate cost
            $table->integer('shipping_days')->nullable(); // Shipping days
            $table->boolean('warranty_enabled')->default(false);
            $table->string('warranty_duration')->nullable();
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // soft delete support
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
