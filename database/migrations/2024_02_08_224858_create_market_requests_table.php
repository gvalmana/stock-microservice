<?php

use App\Models\Product;
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
        Schema::create('market_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->nullable();
            $table->unsignedInteger('retries')->default(0);
            $table->unsignedInteger('quantity_sold')->default(0);
            $table->foreignIdFor(Product::class, 'product_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_requests');
    }
};
