<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Parent category (null = top-level)
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('status')->default('active'); // 1 = active, 0 = inactive
            $table->integer('order_level')->default(0); // optional: hierarchy depth
            $table->string('image')->nullable();
            $table->boolean('featured')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
