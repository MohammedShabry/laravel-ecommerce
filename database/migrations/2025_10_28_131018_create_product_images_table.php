<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // FK to products
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade'); // Optional FK to variant
            $table->string('image_path', 255);
            $table->integer('position')->nullable()->default(0); // ordering of images
            $table->boolean('is_thumbnail')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
