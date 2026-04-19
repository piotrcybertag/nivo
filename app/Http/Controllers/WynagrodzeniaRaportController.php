<?php

namespace App\Http\Controllers;

use App\Models\Pracownik;
use App\Models\Uzytkownik;
use App\Support\AppUrl;
use App\Support\WynagrodzeniaSiatkaWidelek;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WynagrodzeniaRaportController extends Controller
{
    /**
     * Wszystkie id w strukturze linii (id_szefa) od wskazanego korzenia włącznie.
     *
     * @return array<int, int>
     */
    private function idsStrukturyLinii(int $rootId): array
    {
        $ids = [$rootId];
        $queue = [$rootId];
        $seen = [$rootId => true];
        while ($queue !== []) {
            $current = array_shift($queue);
            $dzieci = Pracownik::query()
                ->where('id_szefa', $current)
                ->pluck('id')
                ->all();
            foreach ($dzieci as $id) {
                if (! isset($seen[$id])) {
                    $seen[$id] = true;
                    $ids[] = $id;
                    $queue[] = $id;
                }
            }
        }

        return $ids;
    }

    public function index(Request $request): View
    {
        $szefowieDoFiltra = Pracownik::query()
            ->liczeniJakoPracownicy()
            ->whereIn('id', function ($q): void {
                $q->select('id_szefa')
                    ->from((new Pracownik)->getTable())
                    ->whereNotNull('id_szefa');
            })
            ->orderBy('nazwisko')
            ->orderBy('imie')
            ->get(['id', 'imie', 'nazwisko', 'stanowisko']);

        $rawSzef = $request->query('szef');
        $szefId = is_numeric($rawSzef) ? (int) $rawSzef : null;
        if ($szefId !== null && ! $szefowieDoFiltra->contains('id', $szefId)) {
            $szefId = null;
        }

        $allowedIds = null;
        if ($szefId !== null) {
            $allowedIds = $this->idsStrukturyLinii($szefId);
        }

        $query = Pracownik::query()
            ->liczeniJakoPracownicy()
            ->orderBy('nazwisko')
            ->orderBy('imie');
        if ($allowedIds !== null) {
            $query->whereIn('id', $allowedIds);
        }
        $pracownicy = $query->get();

        $uzytkownik = session('uzytkownik_id') ? Uzytkownik::find(session('uzytkownik_id')) : null;
        $widełkiPoStanowisku = WynagrodzeniaSiatkaWidelek::mapStanowiskoDoWidelek($uzytkownik);

        $wiersze = [];
        $sumaWynagrodzen = 0.0;
        $licznikZWynagrodzeniem = 0;
        $licznikBezPelnychDanych = 0;

        foreach ($pracownicy as $p) {
            $wyn = $p->wynagrodzenie;
            $wym = $p->wymiar;
            $wynF = $wyn !== null && $wyn !== '' ? (float) $wyn : null;
            $wymF = $wym !== null && $wym !== '' ? (float) $wym : null;

            if ($wynF !== null) {
                $sumaWynagrodzen += $wynF;
                $licznikZWynagrodzeniem++;
            }
            if ($wynF === null || $wymF === null) {
                $licznikBezPelnychDanych++;
            }

            $widełki = $widełkiPoStanowisku[$p->stanowisko] ?? null;
            $bandFlag = WynagrodzeniaSiatkaWidelek::flagaPozaWidelkami($wynF, $wymF, $widełki);
            $bandTooltip = WynagrodzeniaSiatkaWidelek::bandTooltip($bandFlag, $wynF, $wymF, $widełki);

            $wiersze[] = [
                'pracownik' => $p,
                'wynagrodzenie' => $wynF,
                'wymiar' => $wymF,
                'band_flag' => $bandFlag,
                'band_tooltip' => $bandTooltip,
            ];
        }

        $sumaWynagrodzen = round($sumaWynagrodzen, 2);

        return view('wynagrodzenia.raport', [
            'wiersze' => $wiersze,
            'sumaWynagrodzen' => $sumaWynagrodzen,
            'licznikZWynagrodzeniem' => $licznikZWynagrodzeniem,
            'licznikBezPelnychDanych' => $licznikBezPelnychDanych,
            'backUrl' => AppUrl::route('kartoteki.pracownicy.index'),
            'raportUrl' => AppUrl::route('wynagrodzenia.raport'),
            'szefowieDoFiltra' => $szefowieDoFiltra,
            'wybranySzefId' => $szefId,
            'pokazLegendeWidelek' => $widełkiPoStanowisku !== [],
        ]);
    }
}
