<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculator_logs', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Nama operator / pembuat
            $table->string('shift');          // Shift (1, 2, 3, dll)
            $table->date('log_date');         // Tanggal pencatatan
            $table->json('menus_data');       // JSON: menu yg dihitung beserta qty
            $table->json('ingredients_data'); // JSON: hasil kalkulasi bahan
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculator_logs');
    }
};
