<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PracownikController;
use App\Http\Controllers\UzytkownikController;
use App\Models\Pracownik;
use App\Services\PracownicyTableService;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/cennik', function () {
    return view('cennik');
})->name('cennik');

Route::get('/upgrade', function () {
    if (!session('uzytkownik_id') || session('login_via_link') || session('uzytkownik_plan') !== 'FREE') {
        return redirect()->route('home')->with('error', 'Strona tylko dla użytkowników planu Free.');
    }
    return view('upgrade');
})->name('upgrade');

Route::get('/upgrade/sukces', function () {
    return view('upgrade-sukces');
})->name('upgrade.sukces');

Route::post('/upgrade', function () {
    if (!session('uzytkownik_id') || session('login_via_link') || session('uzytkownik_plan') !== 'FREE') {
        return redirect()->route('home')->with('error', 'Nieprawidłowe żądanie.');
    }
    $u = \App\Models\Uzytkownik::find(session('uzytkownik_id'));
    if (!$u || $u->plan !== 'FREE') {
        return redirect()->route('home');
    }
    $u->update(['plan' => 'FULL']);
    session(['uzytkownik_plan' => 'FULL']);
    return redirect()->route('home')
        ->with('success', 'Twój plan został zmieniony na Full. Możesz teraz dodawać nieograniczoną liczbę pracowników.')
        ->with('analytics_event', ['name' => 'upgrade_plan', 'params' => []]);
})->name('upgrade.store');

Route::get('/rejestracja', function () {
    $plan = request('plan', 'free');
    if (!in_array($plan, ['free', 'full'], true)) {
        $plan = 'free';
    }
    return view('rejestracja', ['plan' => $plan]);
})->name('rejestracja');

Route::post('/rejestracja', function (\Illuminate\Http\Request $request) {
    $plan = $request->input('plan', 'free');
    if (!in_array($plan, ['free', 'full'], true)) {
        return redirect()->route('rejestracja')->with('error', 'Nieprawidłowy plan.');
    }
    $validated = $request->validate([
        'email' => 'required|email|unique:uzytkownicy,email',
        'imie_nazwisko' => 'required|string|max:255',
        'organizacja' => 'required|string|max:255',
        'password' => 'required|string|min:6|confirmed',
    ]);
    $organizacja = trim($validated['organizacja']);
    if (\App\Models\Uzytkownik::whereRaw('LOWER(typ) = ?', [strtolower($organizacja)])->exists()) {
        return redirect()->back()->withInput($request->only('email', 'imie_nazwisko', 'organizacja'))
            ->with('error', 'Organizacja o tej nazwie jest już zarejestrowana. Wybierz inną nazwę.');
    }
    $validated['typ'] = $organizacja;
    $validated['plan'] = strtoupper($plan);
    $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
    unset($validated['organizacja']);
    \App\Models\Uzytkownik::create($validated);
    return redirect()->route('login')
        ->with('success', 'Konto zostało utworzone. Zaloguj się.')
        ->with('analytics_event', ['name' => 'sign_up', 'params' => []]);
})->name('rejestracja.store');

Route::get('/schemat', function () {
    $pracownikId = request('pracownik');
    $nadSzefem = null;
    $withPodwladni = [
        'podwladni' => fn ($q) => $q->orderBy('nazwisko')->orderBy('imie')->withCount('podwladni')->withCount('podwladniMatrix'),
        'podwladniMatrix' => fn ($q) => $q->orderBy('nazwisko')->orderBy('imie')->withCount('podwladni')->withCount('podwladniMatrix'),
    ];
    $svc = app(PracownicyTableService::class);
    if ($pracownikId) {
        $root = Pracownik::withCount('podwladni')->withCount('podwladniMatrix')
            ->with(array_merge($withPodwladni, ['szef', 'szefMatrix']))
            ->find($pracownikId);
        if (!$root) {
            return redirect()->route('schemat');
        }
        $korzenie = collect([$root]);
        $nadSzefowie = [];
        if ($root->szef) {
            $nadSzefowie[] = [
                'pracownik' => $root->szef,
                'typ' => 'linia',
                'liczba_pracownikow' => $svc->countPracownikowWStrukturze([$root->szef->id]),
            ];
        }
        if ($root->szefMatrix) {
            $nadSzefowie[] = [
                'pracownik' => $root->szefMatrix,
                'typ' => 'matrix',
                'liczba_pracownikow' => $svc->countPracownikowWStrukturze([$root->szefMatrix->id]),
            ];
        }
    } else {
        $korzenie = Pracownik::withCount('podwladni')->withCount('podwladniMatrix')
            ->with($withPodwladni)
            ->whereNull('id_szefa')
            ->orderBy('nazwisko')
            ->orderBy('imie')
            ->get();
        $nadSzefowie = [];
    }
    $ustawCalkowitaLiczbePodwladnych = function ($pracownik) use (&$ustawCalkowitaLiczbePodwladnych) {
        $calkowita = 0;
        foreach ($pracownik->podwladni ?? [] as $pod) {
            $ustawCalkowitaLiczbePodwladnych($pod);
            $calkowita += ($pod->grupa ? 0 : 1) + ($pod->total_podwladni_count ?? 0);
        }
        foreach ($pracownik->podwladniMatrix ?? [] as $pod) {
            $ustawCalkowitaLiczbePodwladnych($pod);
            $calkowita += ($pod->grupa ? 0 : 1) + ($pod->total_podwladni_count ?? 0);
        }
        $pracownik->total_podwladni_count = $calkowita;
    };
    foreach ($korzenie as $k) {
        $ustawCalkowitaLiczbePodwladnych($k);
    }

    $totalPracownikow = $svc->countPracownikowWStrukturze($korzenie->pluck('id')->toArray());

    $szukaj = request('szukaj', '');
    $wynikiWyszukiwania = collect();
    if (strlen($szukaj) >= 1) {
        $wynikiWyszukiwania = Pracownik::where('nazwisko', 'like', '%' . $szukaj . '%')
            ->orWhere('imie', 'like', '%' . $szukaj . '%')
            ->orderBy('nazwisko')
            ->orderBy('imie')
            ->limit(50)
            ->get();
    }
    return view('schemat', compact('korzenie', 'nadSzefowie', 'szukaj', 'wynikiWyszukiwania', 'totalPracownikow'));
})->name('schemat');

Route::get('/przeglad', function () {
    $loadTree = function ($p, $depth = 25) use (&$loadTree) {
        if ($depth <= 0) return;
        $p->load([
            'podwladni' => fn ($q) => $q->orderBy('nazwisko')->orderBy('imie'),
            'podwladniMatrix' => fn ($q) => $q->orderBy('nazwisko')->orderBy('imie'),
        ]);
        foreach ($p->podwladni->concat($p->podwladniMatrix) as $pod) {
            $loadTree($pod, $depth - 1);
        }
    };
    $korzenie = Pracownik::whereNull('id_szefa')
        ->orderBy('nazwisko')
        ->orderBy('imie')
        ->get();
    foreach ($korzenie as $k) {
        $loadTree($k);
    }
    return view('przeglad', compact('korzenie'));
})->name('przeglad');

Route::get('/instrukcja', function () {
    if (!session('uzytkownik_id') || session('login_via_link')) {
        return redirect()->route('home')->with('error', 'Instrukcja jest dostępna tylko po zalogowaniu hasłem.');
    }
    return view('instrukcja');
})->name('instrukcja');

Route::get('/ustawienia', function () {
    if (!session('uzytkownik_id') || session('login_via_link') || session('uzytkownik_typ') === 'ADM') {
        return redirect()->route('home')->with('error', 'Strona niedostępna.');
    }
    $uzytkownik = \App\Models\Uzytkownik::find(session('uzytkownik_id'));
    return view('ustawienia', ['uzytkownik' => $uzytkownik]);
})->name('ustawienia');

Route::post('/ustawienia/generuj-link', function () {
    if (!session('uzytkownik_id') || session('login_via_link') || session('uzytkownik_typ') === 'ADM') {
        return redirect()->route('home')->with('error', 'Strona niedostępna.');
    }
    $uzytkownik = \App\Models\Uzytkownik::find(session('uzytkownik_id'));
    if (!$uzytkownik) {
        return redirect()->route('ustawienia')->with('error', 'Nie znaleziono użytkownika.');
    }
    $token = \Illuminate\Support\Str::random(15);
    while (\App\Models\Uzytkownik::where('login_link_token', $token)->exists()) {
        $token = \Illuminate\Support\Str::random(15);
    }
    $uzytkownik->update(['login_link_token' => $token]);
    $link = url('/' . $token);
    return redirect()
        ->route('ustawienia')
        ->with('success', 'Link wygenerowany.')
        ->with('generated_login_link', $link);
})->name('ustawienia.generuj-link');

Route::get('/kartoteki', function () {
    return view('kartoteki');
})->name('kartoteki');

Route::prefix('kartoteki')->name('kartoteki.')->group(function () {
    Route::resource('pracownicy', PracownikController::class)
        ->parameters(['pracownicy' => 'pracownik'])
        ->names('pracownicy');
    Route::post('uzytkownicy/{uzytkownik}/generuj-link', [UzytkownikController::class, 'generateLoginLink'])
        ->name('uzytkownicy.generate-link')
        ->middleware('uzytkownik.adm');
    Route::resource('uzytkownicy', UzytkownikController::class)
        ->parameters(['uzytkownicy' => 'uzytkownik'])
        ->names('uzytkownicy')
        ->middleware('uzytkownik.adm');
});

Route::get('/{token}', [LoginController::class, 'loginViaLink'])
    ->where('token', '[a-zA-Z0-9]{15}')
    ->name('login.via.link');
