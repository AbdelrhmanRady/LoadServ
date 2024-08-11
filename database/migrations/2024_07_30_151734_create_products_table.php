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
        Schema::create('products', function (Blueprint $table) {
            $table->id('productId'); // Auto-incremented primary key
            $table->string('productName'); 
            $table->text('description'); // Product description
            $table->decimal('price', 10, 2); // Base price for products without sizes
            $table->boolean('hasSizes')->default(false); // Flag to indicate if product has sizes
            $table->boolean('samePriceForAllSizes')->default(false); // Flag to indicate if all sizes have the same price
            $table->integer('stock')->default(0); // Stock availability
            $table->json('images')->nullable(); // JSON column for storing product images
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
