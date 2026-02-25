<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('uzytkownicy', function (Blueprint $table) {
            $table->string('login_link_token', 15)->nullable()->unique()->after('typ');
        });
    }

    public function down(): void
    {
        Schema::table('uzytkownicy', function (Blueprint $table) {
            $table->dropColumn('login_link_token');
        });
    }
};
