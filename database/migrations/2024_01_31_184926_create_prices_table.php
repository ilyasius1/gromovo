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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('cottage_type_id')
                ->references('id')
                ->on('cottage_types')
                ->restrictOnDelete();
            $table->foreignId('period_id')
                ->references('id')
                ->on('periods')
                ->restrictOnDelete();
            $table->foreignId('package_id')
                ->references('id')
                ->on('packages')
                ->restrictOnDelete();
            $table->unsignedInteger('rate');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
