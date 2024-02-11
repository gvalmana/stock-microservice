<?php

use App\Models\OrderRegister;
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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity')->default(0);
            $table->boolean('fulled')->default(false);
            $table->foreignIdFor(OrderRegister::class,'order_register_id')->constrained('order_registers');
            $table->foreignIdFor(Product::class,'product_id')->constrained('products');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
