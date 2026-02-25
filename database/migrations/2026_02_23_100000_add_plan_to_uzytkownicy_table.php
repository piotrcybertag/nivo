<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('uzytkownicy', function (Blueprint $table) {
            $table->string('plan', 10)->nullable()->after('typ');
        });
    }

    public function down(): void
    {
        Schema::table('uzytkownicy', function (Blueprint $table) {
            $table->dropColumn('plan');
        });
    }
};
