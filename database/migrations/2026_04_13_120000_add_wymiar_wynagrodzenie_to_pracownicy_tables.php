<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $add = function (string $tableName): void {
            if (! Schema::hasColumn($tableName, 'wymiar')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->decimal('wymiar', 2, 1)->nullable()->after('grupa');
                    $table->decimal('wynagrodzenie', 12, 2)->nullable()->after('wymiar');
                });
            }
        };

        $add('pracownicy');

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'sqlite') {
            $rows = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name LIKE '%_pracownicy'");
        } else {
            $rows = DB::select('SHOW TABLES');
        }

        foreach ($rows as $row) {
            $name = $row->name ?? array_values((array) $row)[0] ?? null;
            if ($name && $name !== 'pracownicy' && str_ends_with((string) $name, '_pracownicy')) {
                $add($name);
            }
        }
    }

    public function down(): void
    {
        $drop = function (string $tableName): void {
            if (Schema::hasColumn($tableName, 'wymiar')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn(['wynagrodzenie', 'wymiar']);
                });
            }
        };

        $drop('pracownicy');

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'sqlite') {
            $rows = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name LIKE '%_pracownicy'");
        } else {
            $rows = DB::select('SHOW TABLES');
        }

        foreach ($rows as $row) {
            $name = $row->name ?? array_values((array) $row)[0] ?? null;
            if ($name && $name !== 'pracownicy' && str_ends_with((string) $name, '_pracownicy')) {
                $drop($name);
            }
        }
    }
};
