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
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->comment('Анкеты клиентов');
            $table->id();
            $table->string('full_name', 50)
                  ->comment('ФИО');
            $table->string('phone',11)
                  ->comment('Номер телефона');
            $table->string('email', 100)
                  ->comment('E-mail');
            $table->string('document_number', 20)
                  ->comment('Серия и номер паспорта');
            $table->string('document_issued_by', 200)
                  ->comment('Кем выдан паспорта');
            $table->date('document_issued_at')
                  ->comment('Дата выдачи паспорта');
            $table->string('address')
                  ->comment('Адрес регистрации');
            $table->date('birthdate')
                  ->nullable()
                  ->comment('Дата рождения');
            $table->boolean('news_subscription')
                  ->default(false)
                  ->comment('Подписка на новости');
            $table->timestamps();
            $table->unique(['phone', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
