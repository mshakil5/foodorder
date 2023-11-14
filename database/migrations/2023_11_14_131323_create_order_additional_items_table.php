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
        Schema::create('order_additional_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->bigInteger('order_detail_id')->unsigned()->nullable();
            $table->foreign('order_detail_id')->references('id')->on('order_details')->onDelete('cascade');
            $table->bigInteger('additional_item_id')->unsigned()->nullable();
            $table->foreign('additional_item_id')->references('id')->on('additional_items')->onDelete('cascade');
            $table->string('item_name')->nullable();
            $table->string('quantity')->nullable();
            $table->double('price_per_unit',10,2)->default(0);
            $table->double('total_amount',10,2)->default(0);
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
        Schema::dropIfExists('order_additional_items');
    }
};
