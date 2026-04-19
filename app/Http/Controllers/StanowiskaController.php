<?php

namespace App\Http\Controllers;

use App\Models\Pracownik;
use App\Models\StanowiskaGrupaWynagrodzen;
use App\Models\Uzytkownik;
use App\Support\StanowiskaKolejnoscNormalizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StanowiskaController extends Controller
{
    public function index(): View
    {
        $rows = Pracownik::query()
            ->liczeniJakoPracownicy()
            ->select('stanowisko')
            ->groupBy('stanowisko')
            ->orderBy('stanowisko')
            ->get();

        $byName = $rows->keyBy('stanowisko');
        $currentNames = $rows->pluck('stanowisko')->all();

        $u = session('uzytkownik_id') ? Uzytkownik::find(session('uzytkownik_id')) : null;
        $savedNested = StanowiskaKolejnoscNormalizer::normalize(is_array($u?->stanowiska_kolejnosc) ? $u->stanowiska_kolejnosc : []);

        $savedFlatSet = [];
        foreach ($savedNested as $row) {
            foreach ($row as $name) {
                $savedFlatSet[$name] = true;
            }
        }

        $nowe = [];
        foreach ($currentNames as $name) {
            if (! isset($savedFlatSet[$name])) {
                $nowe[] = $name;
            }
        }
        sort($nowe, SORT_NATURAL | SORT_FLAG_CASE);

        $rowsNowe = [];
        foreach ($nowe as $name) {
            $rowsNowe[] = [$byName[$name]];
        }

        $rowsZapamietane = [];
        foreach ($savedNested as $row) {
            $built = [];
            foreach ($row as $name) {
                if (isset($byName[$name])) {
                    $built[] = $byName[$name];
                }
            }
            if ($built !== []) {
                $rowsZapamietane[] = $built;
            }
        }

        $maObaBloki = $rowsNowe !== [] && $rowsZapamietane !== [];

        $canSaveOrder = (bool) session('uzytkownik_id');

        return view('stanowiska.index', compact('rowsNowe', 'rowsZapamietane', 'maObaBloki', 'canSaveOrder'));
    }

    public function saveOrder(Request $request): JsonResponse
    {
        if (! session('uzytkownik_id')) {
            abort(403);
        }

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|array',
            'order.*.*' => 'required|string|max:255',
        ]);

        $u = Uzytkownik::find(session('uzytkownik_id'));
        if (! $u) {
            abort(403);
        }

        $valid = Pracownik::query()
            ->liczeniJakoPracownicy()
            ->select('stanowisko')
            ->orderBy('stanowisko')
            ->groupBy('stanowisko')
            ->pluck('stanowisko')
            ->all();

        $validSet = array_flip($valid);
        $seen = [];
        $cleanRows = [];
        foreach ($validated['order'] as $row) {
            $cleanRow = [];
            foreach ($row as $name) {
                if (! isset($validSet[$name]) || isset($seen[$name])) {
                    continue;
                }
                $seen[$name] = true;
                $cleanRow[] = $name;
            }
            if ($cleanRow !== []) {
                $cleanRows[] = $cleanRow;
            }
        }
        foreach ($valid as $name) {
            if (! isset($seen[$name])) {
                $cleanRows[] = [$name];
            }
        }

        $u->update(['stanowiska_kolejnosc' => $cleanRows]);

        StanowiskaGrupaWynagrodzen::query()
            ->where('uzytkownik_id', $u->id)
            ->where('indeks_grupy', '>=', count($cleanRows))
            ->delete();

        return response()->json([
            'ok' => true,
            'message' => __('app.stanowiska.flash_order_saved'),
        ]);
    }
}
