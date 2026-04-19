<?php

namespace App\Support;

use App\Models\Pracownik;
use App\Models\StanowiskaGrupaWynagrodzen;
use App\Models\Uzytkownik;

class WynagrodzeniaSiatkaWidelek
{
    /**
     * Stanowisko (nazwa) → widełki z zapisanej siatki / kolejności (jak w StanowiskaGrupaWynagrodzenController).
     *
     * @return array<string, array{od: float|null, do: float|null}>
     */
    public static function mapStanowiskoDoWidelek(?Uzytkownik $u): array
    {
        if ($u === null || ! is_array($u->stanowiska_kolejnosc)) {
            return [];
        }

        $valid = Pracownik::query()
            ->liczeniJakoPracownicy()
            ->select('stanowisko')
            ->groupBy('stanowisko')
            ->pluck('stanowisko')
            ->all();
        $validSet = array_flip($valid);
        $savedNested = StanowiskaKolejnoscNormalizer::normalize($u->stanowiska_kolejnosc);

        $map = [];
        foreach ($savedNested as $indeks => $row) {
            $names = [];
            foreach ($row as $name) {
                if (isset($validSet[$name])) {
                    $names[] = $name;
                }
            }
            if ($names === []) {
                continue;
            }
            $rekord = StanowiskaGrupaWynagrodzen::query()
                ->where('uzytkownik_id', $u->id)
                ->where('indeks_grupy', (int) $indeks)
                ->first();
            $od = $rekord !== null && $rekord->wynagrodzenie_od !== null && $rekord->wynagrodzenie_od !== ''
                ? round((float) $rekord->wynagrodzenie_od, 2) : null;
            $do = $rekord !== null && $rekord->wynagrodzenie_do !== null && $rekord->wynagrodzenie_do !== ''
                ? round((float) $rekord->wynagrodzenie_do, 2) : null;
            if ($od === null && $do === null) {
                continue;
            }
            foreach ($names as $n) {
                $map[$n] = ['od' => $od, 'do' => $do];
            }
        }

        return $map;
    }

    /**
     * Widełki w siatce dotyczą pełnego etatu — porównanie przez ekwiwalent: wynagrodzenie / wymiar.
     *
     * @param  array{od: float|null, do: float|null}|null  $widełki
     */
    public static function flagaPozaWidelkami(?float $wynF, ?float $wymF, ?array $widełki): ?string
    {
        if ($wynF === null || $widełki === null) {
            return null;
        }
        if ($wymF === null || $wymF <= 0) {
            return null;
        }
        $eq = round($wynF / $wymF, 2);
        $od = $widełki['od'];
        $do = $widełki['do'];
        if ($od !== null && $do !== null && $od > $do) {
            return null;
        }
        if ($od !== null && $eq < $od) {
            return 'below';
        }
        if ($do !== null && $eq > $do) {
            return 'above';
        }

        return null;
    }

    /**
     * @param  array{od: float|null, do: float|null}|null  $widełki
     */
    public static function bandTooltip(?string $bandFlag, ?float $wynF, ?float $wymF, ?array $widełki): ?string
    {
        if ($bandFlag === null || $wynF === null || $wymF === null || $wymF <= 0 || $widełki === null) {
            return null;
        }
        $eq = round($wynF / $wymF, 2);
        $fmt = static fn (float $v, int $frac) => number_format($v, $frac, '.', '');
        if ($bandFlag === 'below' && $widełki['od'] !== null) {
            return __('app.wynagrodzenia_raport.band_below_tooltip', [
                'od' => $fmt($widełki['od'], 2),
                'eq' => $fmt($eq, 2),
                'wyn' => $fmt($wynF, 2),
                'wym' => $fmt($wymF, 1),
            ]);
        }
        if ($bandFlag === 'above' && $widełki['do'] !== null) {
            return __('app.wynagrodzenia_raport.band_above_tooltip', [
                'do' => $fmt($widełki['do'], 2),
                'eq' => $fmt($eq, 2),
                'wyn' => $fmt($wynF, 2),
                'wym' => $fmt($wymF, 1),
            ]);
        }

        return null;
    }
}
