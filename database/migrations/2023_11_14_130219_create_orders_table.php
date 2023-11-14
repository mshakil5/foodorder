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
            $table->string('invoiceno')->nullable();
            $table->string('date')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->double('total_amount',10,2)->default(0);
            $table->double('net_amount',10,2)->default(0);
            $table->double('discount',10,2)->default(0);
            $table->double('vat_amount',10,2)->default(0);
            $table->string('payment_type')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('collection_date')->nullable();
            $table->string('collection_time')->nullable();
            $table->string('order_ip')->nullable();
            $table->string('lat')->nullable();
            $table->string('lang')->nullable();
            $table->string('status')->default(1);
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
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
