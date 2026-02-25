<?php

namespace App\Http\Controllers;

use App\Models\Pracownik;
use App\Services\PracownicyTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PracownikController extends Controller
{
    public function index(): View
    {
        $pracownicy = Pracownik::with('szef', 'szefMatrix')->orderBy('nazwisko')->orderBy('imie')->paginate(15);
        $limitFree = 10;
        $canAddPracownik = session('uzytkownik_plan') === 'FULL' || Pracownik::count() < $limitFree;
        return view('pracownicy.index', compact('pracownicy', 'canAddPracownik', 'limitFree'));
    }

    public function create(): View|RedirectResponse
    {
        $limitFree = 10;
        if (session('uzytkownik_plan') !== 'FULL' && Pracownik::count() >= $limitFree) {
            return redirect()->route('kartoteki.pracownicy.index')
                ->with('error', 'Plan Free pozwala na maksymalnie 10 pracowników. Przejdź na plan Full w Ustawieniach, aby dodać więcej.');
        }
        $pracownicy = Pracownik::orderBy('nazwisko')->orderBy('imie')->get();
        return view('pracownicy.create', compact('pracownicy'));
    }

    public function store(Request $request): RedirectResponse
    {
        $limitFree = 10;
        if (session('uzytkownik_plan') !== 'FULL' && Pracownik::count() >= $limitFree) {
            return redirect()->route('kartoteki.pracownicy.index')
                ->with('error', 'Plan Free pozwala na maksymalnie 10 pracowników. Przejdź na plan Full w Ustawieniach, aby dodać więcej.');
        }

        $tabela = app(PracownicyTableService::class)->getTableName();
        $validated = $request->validate([
            'imie' => 'required|string|max:255',
            'nazwisko' => 'required|string|max:255',
            'stanowisko' => 'required|string|max:255',
            'id_szefa' => 'nullable|exists:' . $tabela . ',id',
            'szef_matrix' => 'nullable|exists:' . $tabela . ',id',
        ]);

        Pracownik::create($validated);
        return redirect()->route('kartoteki.pracownicy.index')->with('success', 'Pracownik został dodany.');
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
        return view('pracownicy.edit', compact('pracownik', 'pracownicy'));
    }

    public function update(Request $request, Pracownik $pracownik): RedirectResponse
    {
        $tabela = app(PracownicyTableService::class)->getTableName();
        $validated = $request->validate([
            'imie' => 'required|string|max:255',
            'nazwisko' => 'required|string|max:255',
            'stanowisko' => 'required|string|max:255',
            'id_szefa' => 'nullable|exists:' . $tabela . ',id',
            'szef_matrix' => 'nullable|exists:' . $tabela . ',id',
        ]);

        $pracownik->update($validated);
        return redirect()->route('kartoteki.pracownicy.index')->with('success', 'Pracownik został zaktualizowany.');
    }

    public function destroy(Pracownik $pracownik): RedirectResponse
    {
        $pracownik->delete();
        return redirect()->route('kartoteki.pracownicy.index')->with('success', 'Pracownik został usunięty.');
    }
}
