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
        Schema::create('bookings', function (Blueprint $table) {
            $table->comment('Бронирования');
            $table->id();
            $table->foreignId('cottage_id')
                  ->references('id')
                  ->on('cottages')
                  ->cascadeOnDelete();
            $table->foreignId('customer_profile_id')
                  ->references('id')
                  ->on('customer_profiles')
                  ->cascadeOnDelete();
            $table->date('start')
                  ->comment('Дата заезда');
            $table->date('end')
                  ->comment('Дата выезда');
            $table->unsignedInteger('amount')
                  ->comment('Сумма заказа');
            $table->string('contract_number', 50)
                  ->comment('Номер договора');
            $table->timestamp('pay_before')
                  ->comment('Оплатить до');
            $table->unsignedSmallInteger('status')
                  ->comment('Статус заказа');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
