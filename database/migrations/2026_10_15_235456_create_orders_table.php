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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_number')->unique(); // Ej: JJ-2026-0001
        $table->string('customer_name');
        $table->string('customer_email');
        $table->string('customer_phone');
        $table->text('shipping_address');
        $table->string('city');
        $table->decimal('total_amount', 10, 2);
        $table->enum('status', ['pendiente', 'pagado', 'enviado', 'completado', 'cancelado'])->default('pendiente');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
