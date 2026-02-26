<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $addGrupa = function (string $tableName): void {
            if (!Schema::hasColumn($tableName, 'grupa')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->boolean('grupa')->default(false)->after('stanowisko');
                });
            }
        };

        $addGrupa('pracownicy');

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'sqlite') {
            $rows = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name LIKE '%_pracownicy'");
        } else {
            $rows = DB::select("SHOW TABLES");
        }

        foreach ($rows as $row) {
            $name = $row->name ?? array_values((array) $row)[0] ?? null;
            if ($name && $name !== 'pracownicy' && str_ends_with((string) $name, '_pracownicy')) {
                $addGrupa($name);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $dropGrupa = function (string $tableName): void {
            if (Schema::hasColumn($tableName, 'grupa')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('grupa');
                });
            }
        };

        $dropGrupa('pracownicy');

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'sqlite') {
            $rows = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name LIKE '%_pracownicy'");
        } else {
            $rows = DB::select("SHOW TABLES");
        }

        foreach ($rows as $row) {
            $name = $row->name ?? array_values((array) $row)[0] ?? null;
            if ($name && $name !== 'pracownicy' && str_ends_with((string) $name, '_pracownicy')) {
                $dropGrupa($name);
            }
        }
    }
};
