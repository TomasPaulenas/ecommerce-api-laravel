<?php

use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Foreign key: each product belongs to a category
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();

            // Main product information
            $table->string('name');
            $table->text('description')->nullable();

            // Pricing and inventory
            $table->decimal('price', 10, 2); // precise for monetary values
            $table->unsignedInteger('stock')->default(0); // cannot be negative

            // Optional fields
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true); // soft enable/disable product

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
