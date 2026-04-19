<?php

namespace App\Http\Controllers;

use App\Models\Pracownik;
use App\Models\Uzytkownik;
use App\Services\PracownicyTableService;
use App\Support\AppUrl;
use App\Support\WynagrodzeniaSiatkaWidelek;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PracownikController extends Controller
{
    /**
     * @return array<string, mixed>
     */
    private function validatedPracownik(Request $request, string $tabela): array
    {
        $isGrupa = $request->boolean('grupa');
        $dozwoloneWymiary = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1.0];
        $rules = [
            'imie' => 'required|string|max:255',
            'nazwisko' => 'required|string|max:255',
            'stanowisko' => 'required|string|max:255',
            'grupa' => 'boolean',
            'id_szefa' => 'nullable|exists:'.$tabela.',id',
            'szef_matrix' => 'nullable|exists:'.$tabela.',id',
        ];
        if ($isGrupa) {
            $rules['wymiar'] = 'nullable';
            $rules['wynagrodzenie'] = 'nullable';
        } else {
            $rules['wymiar'] = [
                'nullable',
                function (string $attribute, mixed $value, Closure $fail) use ($dozwoloneWymiary): void {
                    if ($value === null || $value === '') {
                        return;
                    }
                    $f = round((float) $value, 1);
                    if (! in_array($f, $dozwoloneWymiary, true)) {
                        $fail(__('employees.wymiar_invalid'));
                    }
                },
            ];
            $rules['wynagrodzenie'] = 'nullable|numeric|min:0';
        }
        $validated = $request->validate($rules);
        $validated['grupa'] = $isGrupa;
        if ($isGrupa) {
            $validated['wymiar'] = null;
            $validated['wynagrodzenie'] = null;
        } else {
            if (! isset($validated['wymiar']) || $validated['wymiar'] === '' || $validated['wymiar'] === null) {
                $validated['wymiar'] = null;
            } else {
                $validated['wymiar'] = round((float) $validated['wymiar'], 1);
            }
            if (! array_key_exists('wynagrodzenie', $validated) || $validated['wynagrodzenie'] === '' || $validated['wynagrodzenie'] === null) {
                $validated['wynagrodzenie'] = null;
            }
        }

        return $validated;
    }

    public function index(Request $request): View
    {
        $q = trim((string) $request->input('q', ''));
        $sort = $request->input('sort', 'nazwisko');
        $dir = strtolower((string) $request->input('dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        if (! in_array($sort, ['nazwisko', 'stanowisko', 'szef', 'grupa'], true)) {
            $sort = 'nazwisko';
        }

        $tabela = app(PracownicyTableService::class)->getTableName();
        $query = Pracownik::with('szef', 'szefMatrix');

        if ($q !== '') {
            $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q);
            $like = '%'.$escaped.'%';
            $query->where(function ($w) use ($like, $q, $tabela) {
                $w->where($tabela.'.imie', 'like', $like)
                    ->orWhere($tabela.'.nazwisko', 'like', $like)
                    ->orWhere($tabela.'.stanowisko', 'like', $like);
                if (ctype_digit($q)) {
                    $w->orWhere($tabela.'.id', (int) $q);
                }
                $w->orWhereHas('szef', function ($s) use ($like) {
                    $s->where('imie', 'like', $like)->orWhere('nazwisko', 'like', $like);
                });
                $w->orWhereHas('szefMatrix', function ($s) use ($like) {
                    $s->where('imie', 'like', $like)->orWhere('nazwisko', 'like', $like);
                });
                $yes = __('employees.yes');
                $no = __('employees.no');
                if (mb_strlen($q) >= 2) {
                    $yL = mb_strtolower($yes);
                    $nL = mb_strtolower($no);
                    $qL = mb_strtolower($q);
                    if (str_contains($yL, $qL) || str_contains($qL, $yL)) {
                        $w->orWhere($tabela.'.grupa', true);
                    }
                    if (str_contains($nL, $qL) || str_contains($qL, $nL)) {
                        $w->orWhere($tabela.'.grupa', false);
                    }
                }
            });
        }

        $query->select($tabela.'.*');

        if ($sort === 'szef') {
            $query->leftJoin($tabela.' as szef_sort', $tabela.'.id_szefa', '=', 'szef_sort.id')
                ->orderBy('szef_sort.nazwisko', $dir)
                ->orderBy('szef_sort.imie', $dir)
                ->orderBy($tabela.'.nazwisko', $dir)
                ->orderBy($tabela.'.imie', $dir);
        } else {
            $query->orderBy($tabela.'.'.$sort, $dir);
            if ($sort === 'nazwisko') {
                $query->orderBy($tabela.'.imie', $dir);
            } elseif (in_array($sort, ['stanowisko', 'grupa'], true)) {
                $query->orderBy($tabela.'.nazwisko', $dir)->orderBy($tabela.'.imie', $dir);
            }
        }

        $pracownicy = $query->paginate(15)->withQueryString();

        $limitFree = 10;
        $canAddPracownik = session('uzytkownik_plan') === 'FULL' || Pracownik::count() < $limitFree;

        return view('pracownicy.index', compact('pracownicy', 'canAddPracownik', 'limitFree', 'q', 'sort', 'dir'));
    }

    public function create(): View|RedirectResponse
    {
        $limitFree = 10;
        if (session('uzytkownik_plan') !== 'FULL' && Pracownik::count() >= $limitFree) {
            return redirect()->to(AppUrl::route('kartoteki.pracownicy.index'))
                ->with('error', __('employees.flash_free_limit'));
        }
        $pracownicy = Pracownik::orderBy('nazwisko')->orderBy('imie')->get();

        return view('pracownicy.create', compact('pracownicy'));
    }

    public function store(Request $request): RedirectResponse
    {
        $limitFree = 10;
        if (session('uzytkownik_plan') !== 'FULL' && Pracownik::count() >= $limitFree) {
            return redirect()->to(AppUrl::route('kartoteki.pracownicy.index'))
                ->with('error', __('employees.flash_free_limit'));
        }

        $tabela = app(PracownicyTableService::class)->getTableName();
        $validated = $this->validatedPracownik($request, $tabela);

        Pracownik::create($validated);
        $count = Pracownik::count();
        $redirect = redirect()->to(AppUrl::route('kartoteki.pracownicy.index'))->with('success', __('employees.flash_created'));
        if ($count === 1) {
            $redirect->with('analytics_events', [
                ['name' => 'create_structure', 'params' => []],
                ['name' => 'add_employee', 'params' => []],
            ]);
        } else {
            $redirect->with('analytics_event', ['name' => 'add_employee', 'params' => []]);
        }

        return $redirect;
    }

    public function show(Pracownik $pracownik): View
    {
        $pracownik->load('szef', 'szefMatrix', 'podwladni', 'podwladniMatrix');

        return view('pracownicy.show', compact('pracownik'));
    }

    public function edit(Pracownik $pracownik): View
    {
        $pracownicy = Pracownik::where('id', '!=', $pracownik->id)
            ->orderBy('nazwisko')->orderBy('imie')->get();

        $uzytkownik = session('uzytkownik_id') ? Uzytkownik::find(session('uzytkownik_id')) : null;
        $widełkiMap = WynagrodzeniaSiatkaWidelek::mapStanowiskoDoWidelek($uzytkownik);
        $stanowiskoDoWidelek = old('stanowisko', $pracownik->stanowisko);
        $widełki = $widełkiMap[$stanowiskoDoWidelek] ?? null;
        $wynRaw = old('wynagrodzenie', $pracownik->wynagrodzenie);
        $wymRaw = old('wymiar', $pracownik->wymiar);
        $wynF = $wynRaw !== null && $wynRaw !== '' ? (float) $wynRaw : null;
        $wymF = $wymRaw !== null && $wymRaw !== '' ? (float) $wymRaw : null;
        $jestGrupa = (bool) old('grupa', $pracownik->grupa);
        $wynagrodzenieBandFlag = null;
        $wynagrodzenieBandTooltip = null;
        if (! $jestGrupa) {
            $wynagrodzenieBandFlag = WynagrodzeniaSiatkaWidelek::flagaPozaWidelkami($wynF, $wymF, $widełki);
            $wynagrodzenieBandTooltip = WynagrodzeniaSiatkaWidelek::bandTooltip($wynagrodzenieBandFlag, $wynF, $wymF, $widełki);
        }

        return view('pracownicy.edit', compact(
            'pracownik',
            'pracownicy',
            'wynagrodzenieBandFlag',
            'wynagrodzenieBandTooltip',
        ));
    }

    public function update(Request $request, Pracownik $pracownik): RedirectResponse
    {
        $tabela = app(PracownicyTableService::class)->getTableName();
        $validated = $this->validatedPracownik($request, $tabela);

        $pracownik->update($validated);

        return redirect()->to(AppUrl::route('kartoteki.pracownicy.index'))->with('success', __('employees.flash_updated'));
    }

    public function destroy(Pracownik $pracownik): RedirectResponse
    {
        $pracownik->delete();

        return redirect()->to(AppUrl::route('kartoteki.pracownicy.index'))->with('success', __('employees.flash_deleted'));
    }
}
