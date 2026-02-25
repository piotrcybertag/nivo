<?php

namespace App\Http\Controllers;

use App\Models\Uzytkownik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UzytkownikController extends Controller
{
    public function index(): View
    {
        $uzytkownicy = Uzytkownik::orderBy('imie_nazwisko')->paginate(15);
        return view('uzytkownicy.index', compact('uzytkownicy'));
    }

    public function create(): View
    {
        return view('uzytkownicy.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['plan' => $request->input('plan') ?: null]);
        $validated = $request->validate([
            'email' => 'required|email|unique:uzytkownicy,email',
            'imie_nazwisko' => 'required|string|max:255',
            'typ' => 'required|string|max:255',
            'plan' => 'nullable|in:FREE,FULL',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['plan'] = $validated['plan'] ?? null;
        Uzytkownik::create($validated);
        return redirect()->route('kartoteki.uzytkownicy.index')->with('success', 'Użytkownik został dodany.');
    }

    public function show(Uzytkownik $uzytkownik): View
    {
        return view('uzytkownicy.show', compact('uzytkownik'));
    }

    public function edit(Uzytkownik $uzytkownik): View
    {
        return view('uzytkownicy.edit', compact('uzytkownik'));
    }

    public function generateLoginLink(Uzytkownik $uzytkownik): RedirectResponse
    {
        $token = Str::random(15);
        while (Uzytkownik::where('login_link_token', $token)->exists()) {
            $token = Str::random(15);
        }
        $uzytkownik->update(['login_link_token' => $token]);
        $link = url('/' . $token);

        return redirect()
            ->route('kartoteki.uzytkownicy.edit', $uzytkownik)
            ->with('success', 'Link wygenerowany.')
            ->with('generated_login_link', $link);
    }

    public function update(Request $request, Uzytkownik $uzytkownik): RedirectResponse
    {
        $request->merge(['plan' => $request->input('plan') ?: null]);
        $validated = $request->validate([
            'email' => 'required|email|unique:uzytkownicy,email,' . $uzytkownik->id,
            'imie_nazwisko' => 'required|string|max:255',
            'typ' => 'required|string|max:255',
            'plan' => 'nullable|in:FREE,FULL',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $validated['plan'] = !empty($validated['plan']) ? $validated['plan'] : null;
        $uzytkownik->update($validated);
        return redirect()->route('kartoteki.uzytkownicy.index')->with('success', 'Użytkownik został zaktualizowany.');
    }

    public function destroy(Uzytkownik $uzytkownik): RedirectResponse
    {
        $uzytkownik->delete();
        return redirect()->route('kartoteki.uzytkownicy.index')->with('success', 'Użytkownik został usunięty.');
    }
}
