<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->enum('status', ['Processing', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled'])
                  ->default('Processing');

            // Financials
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_fee', 10, 2)->default(15.00);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Shipping address
            $table->string('shipping_name');
            $table->string('shipping_phone');
            $table->string('shipping_address1');
            $table->string('shipping_address2')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_postcode');
            $table->string('shipping_state');
            $table->text('delivery_notes')->nullable();

            // Payment
            $table->enum('payment_method', ['fpx', 'card', 'ewallet', 'cod'])->default('fpx');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
