<?php

namespace App\Models;

use App\Services\PracownicyTableService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pracownik extends Model
{
    public function getTable(): string
    {
        return app(PracownicyTableService::class)->getTableName();
    }

    protected $fillable = [
        'imie',
        'nazwisko',
        'stanowisko',
        'grupa',
        'id_szefa',
        'szef_matrix',
    ];

    protected $casts = [
        'grupa' => 'boolean',
    ];

    /**
     * Scope: tylko pozycje liczone jako pracownicy (nie grupy) — do limitu planu.
     */
    public function scopeLiczeniJakoPracownicy($query)
    {
        return $query->where(function ($q) {
            $q->where('grupa', false)->orWhereNull('grupa');
        });
    }

    public function szef(): BelongsTo
    {
        return $this->belongsTo(Pracownik::class, 'id_szefa');
    }

    public function szefMatrix(): BelongsTo
    {
        return $this->belongsTo(Pracownik::class, 'szef_matrix');
    }

    public function podwladni(): HasMany
    {
        return $this->hasMany(Pracownik::class, 'id_szefa');
    }

    public function podwladniMatrix(): HasMany
    {
        return $this->hasMany(Pracownik::class, 'szef_matrix');
    }

    public function getImieNazwiskoAttribute(): string
    {
        return trim("{$this->imie} {$this->nazwisko}");
    }
}
