<?php

declare(strict_types=1);

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
        Schema::create('cottages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->foreignId('cottage_type_id')
                ->references('id')
                ->on('cottage_types')
                ->restrictOnDelete();
            $table->foreignId('main_gallery_id')
                ->nullable()
                ->references('id')
                ->on('galleries')
                ->nullOnDelete();
            $table->foreignId('schema_gallery_id')
                ->nullable()
                ->references('id')
                ->on('galleries')
                ->nullOnDelete();
            $table->foreignId('summer_gallery_id')
                ->nullable()
                ->references('id')
                ->on('galleries')
                ->nullOnDelete();
            $table->foreignId('winter_gallery_id')
                ->nullable()
                ->references('id')
                ->on('galleries')
                ->nullOnDelete();
            $table->text('description')->nullable();
            $table->smallInteger('area')->default(0);
            $table->smallInteger('floors')->default(1);
            $table->smallInteger('bedrooms')->default(0);
            $table->smallInteger('single_beds')->default(0);
            $table->smallInteger('double_beds')->default(0);
            $table->smallInteger('additional_single_beds')->default(0);
            $table->smallInteger('additional_double_beds')->default(0);
            $table->smallInteger('bathrooms')->default(0);
            $table->smallInteger('showers')->default(0);
            $table->boolean('sauna')->default(false);
            $table->boolean('fireplace')->default(false);
            $table->json('floor1_features')->nullable();
            $table->json('floor2_features')->nullable();
            $table->json('floor3_features')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cottages');
    }
};
