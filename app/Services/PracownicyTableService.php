<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class PracownicyTableService
{
    /**
     * Zwraca nazwę tabeli pracowników dla aktualnego użytkownika (sesji).
     * ADM lub brak logowania → 'pracownicy', inaczej '{typ}_pracownicy'.
     */
    public function getTableName(): string
    {
        $typ = session('uzytkownik_typ');
        if ($typ === null || $typ === 'ADM') {
            return 'pracownicy';
        }
        $prefix = $this->sanitizeTyp($typ);
        return $prefix === '' ? 'pracownicy' : $prefix . '_pracownicy';
    }

    /**
     * Zwraca rzeczywistą liczbę pracowników (bez grup) w całej podległej strukturze dla podanych ID korzeni.
     * Używa rekurencyjnego CTE — liczy całe drzewo, nie tylko załadowany poziom.
     */
    public function countPracownikowWStrukturze(array $rootIds): int
    {
        if ($rootIds === []) {
            return 0;
        }
        $table = $this->getTableName();
        $placeholders = implode(',', array_fill(0, count($rootIds), '?'));
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'sqlite') {
            $sql = "WITH RECURSIVE subtree(id) AS (
                SELECT id FROM {$table} WHERE id IN ({$placeholders})
                UNION ALL
                SELECT p.id FROM {$table} p
                INNER JOIN subtree s ON p.id_szefa = s.id OR p.szef_matrix = s.id
            )
            SELECT COUNT(*) as c FROM {$table} p
            WHERE p.id IN (SELECT id FROM subtree) AND (COALESCE(p.grupa, 0) = 0)";
        } else {
            $sql = "WITH RECURSIVE subtree(id) AS (
                SELECT id FROM {$table} WHERE id IN ({$placeholders})
                UNION ALL
                SELECT p.id FROM {$table} p
                INNER JOIN subtree s ON p.id_szefa = s.id OR p.szef_matrix = s.id
            )
            SELECT COUNT(*) as c FROM {$table} p
            WHERE p.id IN (SELECT id FROM subtree) AND (COALESCE(p.grupa, 0) = 0)";
        }
        $result = DB::select($sql, $rootIds);
        return (int) ($result[0]->c ?? 0);
    }

    /**
     * Tworzy tabelę pracowników z prefiksem typu (jeśli nie istnieje) dla aktualnie zalogowanego użytkownika (non-ADM).
     * Wywołać przy logowaniu, żeby przy pierwszym logowaniu użytkownika danego typu tabela powstała.
     */
    public function ensureTableForCurrentUser(): void
    {
        $typ = session('uzytkownik_typ');
        if ($typ === null || $typ === 'ADM') {
            return;
        }
        $tableName = $this->getTableName();
        if ($tableName === 'pracownicy') {
            return;
        }
        if (Schema::hasTable($tableName)) {
            return;
        }
        $this->createPracownicyTable($tableName);
    }

    private function sanitizeTyp(string $typ): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $typ));
    }

    private function createPracownicyTable(string $tableName): void
    {
        Schema::create($tableName, function (Blueprint $table) use ($tableName) {
            $table->id();
            $table->string('imie');
            $table->string('nazwisko');
            $table->string('stanowisko');
            $table->boolean('grupa')->default(false);
            $table->foreignId('id_szefa')->nullable()->constrained($tableName)->nullOnDelete();
            $table->foreignId('szef_matrix')->nullable()->constrained($tableName)->nullOnDelete();
            $table->timestamps();
        });
    }
}
