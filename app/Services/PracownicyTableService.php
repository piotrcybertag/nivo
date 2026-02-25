<?php

namespace App\Services;

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
            $table->foreignId('id_szefa')->nullable()->constrained($tableName)->nullOnDelete();
            $table->foreignId('szef_matrix')->nullable()->constrained($tableName)->nullOnDelete();
            $table->timestamps();
        });
    }
}
