<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kart_sahibi');
            $table->string('son_dort_hane', 4);
            $table->string('son_kullanma_ay', 2);
            $table->string('son_kullanma_yil', 4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_cards');
    }
};
