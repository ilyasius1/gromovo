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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('service_category_id')
                ->references('id')
                ->on('service_categories')
                ->cascadeOnDelete();
            $table->string('attention', 255)->nullable();
            $table->string('price', 100)->nullable();
            $table->string('price_per_hour', 100)->nullable();
            $table->string('price_per_day', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
