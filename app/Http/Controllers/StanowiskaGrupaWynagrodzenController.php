<?php

namespace App\Http\Controllers;

use App\Models\Pracownik;
use App\Models\StanowiskaGrupaWynagrodzen;
use App\Models\Uzytkownik;
use App\Support\AppUrl;
use App\Support\StanowiskaKolejnoscNormalizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StanowiskaGrupaWynagrodzenController extends Controller
{
    private function uzytkownikOrAbort(): Uzytkownik
    {
        $id = session('uzytkownik_id');
        if (! $id) {
            abort(403);
        }
        $u = Uzytkownik::find($id);
        if (! $u) {
            abort(403);
        }

        return $u;
    }

    /**
     * @return array<int, array{indeks: int, numer: int, stanowiska: array<int, string>, rekord: StanowiskaGrupaWynagrodzen|null}>
     */
    private function buildGrupy(Uzytkownik $u): array
    {
        $valid = Pracownik::query()
            ->liczeniJakoPracownicy()
            ->select('stanowisko')
            ->groupBy('stanowisko')
            ->pluck('stanowisko')
            ->all();
        $validSet = array_flip($valid);
        $savedNested = StanowiskaKolejnoscNormalizer::normalize(
            is_array($u->stanowiska_kolejnosc) ? $u->stanowiska_kolejnosc : []
        );
        $grupy = [];
        $numer = 0;
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
            $numer++;
            $grupy[] = [
                'indeks' => (int) $indeks,
                'numer' => $numer,
                'stanowiska' => $names,
                'rekord' => StanowiskaGrupaWynagrodzen::query()
                    ->where('uzytkownik_id', $u->id)
                    ->where('indeks_grupy', (int) $indeks)
                    ->first(),
            ];
        }

        return $grupy;
    }

    /**
     * @return array<int, int>
     */
    private function allowedIndeksy(Uzytkownik $u): array
    {
        return array_map(fn (array $g) => (int) $g['indeks'], $this->buildGrupy($u));
    }

    public function index(): View
    {
        $u = $this->uzytkownikOrAbort();
        $grupy = $this->buildGrupy($u);

        return view('stanowiska.siatka-wynagrodzen', [
            'grupy' => $grupy,
            'backUrl' => AppUrl::route('stanowiska'),
        ]);
    }

    public function save(Request $request): RedirectResponse
    {
        $u = $this->uzytkownikOrAbort();
        $allowed = $this->allowedIndeksy($u);
        if ($allowed === []) {
            return redirect()->route(AppUrl::uiLocale().'.stanowiska.siatka-wynagrodzen')
                ->with('error', __('app.stanowiska.siatka_error_indeks'));
        }

        $validated = $request->validate([
            'grupy' => 'required|array|size:'.count($allowed),
            'grupy.*.indeks_grupy' => 'required|integer|min:0',
            'grupy.*.wynagrodzenie_od' => 'nullable|numeric|min:0',
            'grupy.*.wynagrodzenie_do' => 'nullable|numeric|min:0',
        ]);

        $submitted = array_map(fn (array $r) => (int) $r['indeks_grupy'], $validated['grupy']);
        $expected = $allowed;
        sort($submitted, SORT_NUMERIC);
        sort($expected, SORT_NUMERIC);
        if ($submitted !== $expected) {
            return redirect()->route(AppUrl::uiLocale().'.stanowiska.siatka-wynagrodzen')
                ->with('error', __('app.stanowiska.siatka_error_indeks'));
        }

        foreach ($validated['grupy'] as $row) {
            $od = $row['wynagrodzenie_od'] ?? null;
            $do = $row['wynagrodzenie_do'] ?? null;
            if ($od !== null && $do !== null && (float) $od > (float) $do) {
                return redirect()->back()->withInput()->with('error', __('app.stanowiska.siatka_error_range'));
            }

            StanowiskaGrupaWynagrodzen::query()->updateOrCreate(
                [
                    'uzytkownik_id' => $u->id,
                    'indeks_grupy' => (int) $row['indeks_grupy'],
                ],
                [
                    'wynagrodzenie_od' => $od,
                    'wynagrodzenie_do' => $do,
                ]
            );
        }

        return redirect()->route(AppUrl::uiLocale().'.stanowiska.siatka-wynagrodzen')
            ->with('success', __('app.stanowiska.siatka_saved'));
    }
}
