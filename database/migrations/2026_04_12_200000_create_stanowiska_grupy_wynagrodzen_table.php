<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stanowiska_grupy_wynagrodzen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uzytkownik_id')->constrained('uzytkownicy')->cascadeOnDelete();
            $table->unsignedInteger('indeks_grupy');
            $table->decimal('wynagrodzenie_od', 12, 2)->nullable();
            $table->decimal('wynagrodzenie_do', 12, 2)->nullable();
            $table->timestamps();

            $table->unique(['uzytkownik_id', 'indeks_grupy']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stanowiska_grupy_wynagrodzen');
    }
};
