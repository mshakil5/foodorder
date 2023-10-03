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
        Schema::create('additional_item_titles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('titleid')->nullable();
            $table->string('slug')->nullable();
            $table->double('amount',10,2)->nullable();
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
        Schema::dropIfExists('additional_item_titles');
    }
};
