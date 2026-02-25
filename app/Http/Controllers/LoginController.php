<?php

namespace App\Http\Controllers;

use App\Models\Uzytkownik;
use App\Services\PracownicyTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        if (session('uzytkownik_id')) {
            session()->forget(['uzytkownik_id', 'uzytkownik_typ', 'uzytkownik_plan', 'uzytkownik_imie_nazwisko', 'login_via_link']);
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $uzytkownik = Uzytkownik::where('email', $request->email)->first();

        if (!$uzytkownik || !Hash::check($request->password, $uzytkownik->password)) {
            throw ValidationException::withMessages([
                'email' => ['Podane dane logowania są nieprawidłowe.'],
            ]);
        }

        session([
            'uzytkownik_id' => $uzytkownik->id,
            'uzytkownik_typ' => $uzytkownik->typ,
            'uzytkownik_plan' => $uzytkownik->plan,
            'uzytkownik_imie_nazwisko' => $uzytkownik->imie_nazwisko,
            'login_via_link' => false,
        ]);

        if ($uzytkownik->typ !== 'ADM') {
            app(PracownicyTableService::class)->ensureTableForCurrentUser();
        }

        return redirect()->intended(route('home'))->with('success', 'Zalogowano.');
    }

    public function logout(Request $request)
    {
        session()->forget(['uzytkownik_id', 'uzytkownik_typ', 'uzytkownik_plan', 'uzytkownik_imie_nazwisko', 'login_via_link']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Wylogowano.');
    }

    public function loginViaLink(string $token): RedirectResponse
    {
        $uzytkownik = Uzytkownik::where('login_link_token', $token)->first();
        if (!$uzytkownik) {
            return redirect()->route('login')->with('error', 'Link jest nieprawidłowy lub wygasł.');
        }

        session([
            'uzytkownik_id' => $uzytkownik->id,
            'uzytkownik_typ' => $uzytkownik->typ,
            'uzytkownik_plan' => $uzytkownik->plan,
            'uzytkownik_imie_nazwisko' => $uzytkownik->imie_nazwisko,
            'login_via_link' => true,
        ]);

        if ($uzytkownik->typ !== 'ADM') {
            app(PracownicyTableService::class)->ensureTableForCurrentUser();
        }

        return redirect()->route('home')->with('success', 'Zalogowano przez link.');
    }
}
