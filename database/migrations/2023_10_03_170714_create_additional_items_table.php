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
        Schema::create('additional_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('additional_item_title_id')->unsigned()->nullable();
            $table->foreign('additional_item_title_id')->references('id')->on('additional_item_titles')->onDelete('cascade');
            $table->string('item_name')->nullable();
            $table->string('item_status')->nullable();
            $table->longText('description')->nullable();
            $table->double('amount',10,2)->default(0);
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
        Schema::dropIfExists('additional_items');
    }
};
