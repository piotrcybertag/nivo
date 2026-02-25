<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE_CYBERTAG = 'cybertag_pracownicy';
    private const TABLE_MAIN = 'pracownicy';

    /**
     * Usuwa wszystkich z tabeli Cybertag i kopiuje tam wszystkich pracowników z tabeli bez prefiksu.
     */
    public function up(): void
    {
        if (!Schema::hasTable(self::TABLE_CYBERTAG)) {
            return;
        }

        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
        }

        DB::table(self::TABLE_CYBERTAG)->delete();

        $rows = DB::table(self::TABLE_MAIN)->orderBy('id')->get();
        if ($rows->isNotEmpty()) {
            foreach ($rows as $row) {
                DB::table(self::TABLE_CYBERTAG)->insert([
                    'id' => $row->id,
                    'imie' => $row->imie,
                    'nazwisko' => $row->nazwisko,
                    'stanowisko' => $row->stanowisko,
                    'id_szefa' => $row->id_szefa,
                    'szef_matrix' => $row->szef_matrix ?? null,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ]);
            }
            if ($driver === 'mysql') {
                $nextId = (int) $rows->max('id') + 1;
                DB::unprepared('ALTER TABLE ' . self::TABLE_CYBERTAG . ' AUTO_INCREMENT = ' . $nextId);
            }
        }

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }
    }

    public function down(): void
    {
        // Nie przywracamy poprzedniej zawartości tabeli Cybertag
    }
};
