<?php

namespace App\Support;

final class StanowiskaKolejnoscNormalizer
{
    /**
     * @param  array<int, mixed>  $raw
     * @return array<int, array<int, string>>
     */
    public static function normalize(array $raw): array
    {
        if ($raw === []) {
            return [];
        }
        $first = reset($raw);
        if (is_string($first)) {
            return array_map(
                fn (string $s) => [$s],
                array_values(array_filter($raw, fn ($x) => is_string($x) && $x !== ''))
            );
        }
        $out = [];
        foreach ($raw as $row) {
            if (! is_array($row)) {
                continue;
            }
            $r = array_values(array_filter($row, fn ($s) => is_string($s) && $s !== ''));
            if ($r !== []) {
                $out[] = $r;
            }
        }

        return $out;
    }
}
