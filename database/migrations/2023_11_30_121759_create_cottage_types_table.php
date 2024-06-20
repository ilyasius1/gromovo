<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cottage_types', static function (Blueprint $table): void {
            $table->id();
            $table->string('name', 255)->unique();
            $table->unsignedSmallInteger('main_places')
                  ->comment('Количество основных мест');
            $table->unsignedSmallInteger('additional_places')
                  ->default(0)
                  ->comment('Количество дополнительных мест');
            $table->unsignedSmallInteger('children_places')
                  ->default(0)
                  ->comment('Количество дополнительных мест для детей от 3 до 12 лет');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cottage_types');
    }
};
