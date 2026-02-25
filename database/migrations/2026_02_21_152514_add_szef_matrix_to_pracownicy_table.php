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
        Schema::table('pracownicy', function (Blueprint $table) {
            $table->foreignId('szef_matrix')->nullable()->after('id_szefa')->constrained('pracownicy')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pracownicy', function (Blueprint $table) {
            $table->dropForeign(['szef_matrix']);
        });
    }
};
