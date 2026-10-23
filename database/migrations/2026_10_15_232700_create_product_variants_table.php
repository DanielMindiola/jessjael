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
    Schema::create('product_variants', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->string('sku')->unique(); // Código único (ej: ZARA-CAM-M-NEGRO)
        $table->string('size'); // XS, S, M, L, XL, etc.
        $table->string('color'); // Negro, Blanco, Azul, etc.
        $table->string('color_code')->nullable(); // Código Hexadecimal (ej: #000000)
        $table->integer('stock')->default(0);
        $table->decimal('additional_price', 10, 2)->default(0.00); // Para cobros extra si aplica
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
