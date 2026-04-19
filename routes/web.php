<?php

use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\FullPlanPaymentController;
use App\Http\Controllers\LandingContactController;
use App\Http\Controllers\LandingFunkcjaController;
use App\Http\Controllers\LandingLocaleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PracownikController;
use App\Http\Controllers\StanowiskaController;
use App\Http\Controllers\StanowiskaGrupaWynagrodzenController;
use App\Http\Controllers\UzytkownikController;
use App\Http\Controllers\WynagrodzeniaRaportController;
use App\Models\Pracownik;
use App\Models\Uzytkownik;
use App\Services\PracownicyTableService;
use App\Support\AdminLog;
use App\Support\AppUrl;
use App\Support\LandingAlternateUrls;
use App\Support\LandingLocalePreference;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/favicon.ico', function () {
    $path = public_path('nivo-favicon.ico');
    if (! is_readable($path)) {
        abort(404);
    }

    return response()->file($path, [
        'Content-Type' => 'image/x-icon',
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
    ]);
});

Route::get('/robots.txt', function () {
    $base = rtrim((string) config('app.url'), '/');
    $body = implode("\n", [
        'User-agent: *',
        'Allow: /',
        '',
        'Sitemap: '.$base.'/sitemap.xml',
    ]);

    return response($body, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
});

Route::get('/landing/set-locale/{locale}', LandingLocaleController::class)
    ->middleware('admin.audit:nav')
    ->where('locale', 'pl|en|es|fr|de')
    ->name('landing.set_locale');

$showRejestracjaForm = static function () {
    $plan = request('plan', 'free');
    if (! in_array($plan, ['free', 'full'], true)) {
        $plan = 'free';
    }

    return view('rejestracja', ['plan' => $plan]);
};

$storeRejestracja = static function (Request $request) {
    $plan = $request->input('plan', 'free');
    if (! in_array($plan, ['free', 'full'], true)) {
        $loc = LandingAlternateUrls::registrationSiteLocale($request);

        return redirect()->route($loc.'.rejestracja')
            ->with('error', __('registration.error_invalid_plan'));
    }
    $validated = $request->validate([
        'email' => 'required|email|unique:uzytkownicy,email',
        'imie_nazwisko' => 'required|string|max:255',
        'organizacja' => 'required|string|max:255',
        'password' => 'required|string|min:6|confirmed',
    ]);
    $organizacja = trim($validated['organizacja']);
    if (Uzytkownik::whereRaw('LOWER(typ) = ?', [strtolower($organizacja)])->exists()) {
        return redirect()->back()->withInput($request->only('email', 'imie_nazwisko', 'organizacja'))
            ->with('error', __('registration.error_org_taken'));
    }
    $validated['typ'] = $organizacja;
    $validated['plan'] = strtoupper($plan);
    $validated['password'] = Hash::make($validated['password']);
    unset($validated['organizacja']);
    $u = Uzytkownik::create($validated);
    AdminLog::userRegistered((string) $u->imie_nazwisko, (string) $u->plan);

    $loc = LandingAlternateUrls::registrationSiteLocale($request);

    return redirect()->route($loc.'.login')
        ->with('success', __('registration.success_created'))
        ->with('analytics_event', ['name' => 'sign_up', 'params' => []]);
};

$schematHandler = static function (): View|RedirectResponse {
    $pracownikId = request('pracownik');
    $withPodwladni = [
        'podwladni' => fn ($q) => $q->orderBy('nazwisko')->orderBy('imie')->withCount('podwladni')->withCount('podwladniMatrix'),
        'podwladniMatrix' => fn ($q) => $q->orderBy('nazwisko')->orderBy('imie')->withCount('podwladni')->withCount('podwladniMatrix'),
    ];
    $svc = app(PracownicyTableService::class);
    if ($pracownikId) {
        $root = Pracownik::withCount('podwladni')->withCount('podwladniMatrix')
            ->with(array_merge($withPodwladni, ['szef', 'szefMatrix']))
            ->find($pracownikId);
        if (! $root) {
            $rn = request()->route()?->getName();

            return is_string($rn) ? redirect()->route($rn) : redirect()->route(AppUrl::uiLocale().'.schemat');
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
        $wynikiWyszukiwania = Pracownik::where('nazwisko', 'like', '%'.$szukaj.'%')
            ->orWhere('imie', 'like', '%'.$szukaj.'%')
            ->orderBy('nazwisko')
            ->orderBy('imie')
            ->limit(50)
            ->get();
    }

    return view('schemat', compact('korzenie', 'nadSzefowie', 'szukaj', 'wynikiWyszukiwania', 'totalPracownikow'));
};

$przegladHandler = static function (): View {
    $loadTree = function ($p, $depth = 25) use (&$loadTree) {
        if ($depth <= 0) {
            return;
        }
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
};

$registerLocaleAppRoutes = static function (string $loc) use ($schematHandler, $przegladHandler): void {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name($loc.'.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name($loc.'.logout');

    Route::get('/upgrade', static function () {
        if (! session('uzytkownik_id') || session('login_via_link') || session('uzytkownik_plan') !== 'FREE') {
            return redirect()->route('home')->with('error', __('app.errors.upgrade_page_free_only'));
        }

        return view('upgrade');
    })->name($loc.'.upgrade');

    Route::get('/upgrade/sukces', static fn () => view('upgrade-sukces'))->name($loc.'.upgrade.sukces');

    Route::post('/upgrade', static function () {
        if (! session('uzytkownik_id') || session('login_via_link') || session('uzytkownik_plan') !== 'FREE') {
            return redirect()->route('home')->with('error', __('app.errors.upgrade_invalid_request'));
        }
        $u = Uzytkownik::find(session('uzytkownik_id'));
        if (! $u || $u->plan !== 'FREE') {
            return redirect()->route('home');
        }
        $u->update(['plan' => 'FULL']);
        session(['uzytkownik_plan' => 'FULL']);

        return redirect()->route('home')
            ->with('success', __('app.errors.upgrade_plan_changed'))
            ->with('analytics_event', ['name' => 'upgrade_plan', 'params' => []]);
    })->name($loc.'.upgrade.store');

    Route::get('/schemat', $schematHandler)->name($loc.'.schemat');
    Route::get('/przeglad', $przegladHandler)->name($loc.'.przeglad');
    Route::get('/stanowiska', [StanowiskaController::class, 'index'])->name($loc.'.stanowiska');
    Route::post('/stanowiska/kolejnosc', [StanowiskaController::class, 'saveOrder'])->name($loc.'.stanowiska.kolejnosc');
    Route::get('/stanowiska/siatka-wynagrodzen', [StanowiskaGrupaWynagrodzenController::class, 'index'])->name($loc.'.stanowiska.siatka-wynagrodzen');
    Route::post('/stanowiska/siatka-wynagrodzen', [StanowiskaGrupaWynagrodzenController::class, 'save'])->name($loc.'.stanowiska.siatka-wynagrodzen.save');

    Route::get('/wynagrodzenia', [WynagrodzeniaRaportController::class, 'index'])->name($loc.'.wynagrodzenia.raport');

    Route::get('/instrukcja', static function () {
        if (! session('uzytkownik_id') || session('login_via_link')) {
            return redirect()->route('home')->with('error', __('app.errors.instrukcja_password_only'));
        }

        return view('instrukcja');
    })->name($loc.'.instrukcja');

    Route::get('/ustawienia', static function () {
        if (! session('uzytkownik_id') || session('login_via_link') || session('uzytkownik_typ') === 'ADM') {
            return redirect()->route('home')->with('error', __('app.errors.page_unavailable'));
        }
        $uzytkownik = Uzytkownik::find(session('uzytkownik_id'));

        return view('ustawienia', ['uzytkownik' => $uzytkownik]);
    })->name($loc.'.ustawienia');

    Route::post('/ustawienia/generuj-link', static function () use ($loc) {
        if (! session('uzytkownik_id') || session('login_via_link') || session('uzytkownik_typ') === 'ADM') {
            return redirect()->route('home')->with('error', __('app.errors.page_unavailable'));
        }
        $uzytkownik = Uzytkownik::find(session('uzytkownik_id'));
        if (! $uzytkownik) {
            return redirect()->route($loc.'.ustawienia')->with('error', __('app.errors.user_not_found'));
        }
        $token = Str::random(15);
        while (Uzytkownik::where('login_link_token', $token)->exists()) {
            $token = Str::random(15);
        }
        $uzytkownik->update(['login_link_token' => $token]);
        $link = url('/'.$token);

        return redirect()
            ->route($loc.'.ustawienia')
            ->with('success', __('app.errors.link_generated'))
            ->with('generated_login_link', $link);
    })->name($loc.'.ustawienia.generuj-link');

    Route::get('/kartoteki', static fn () => view('kartoteki'))->name($loc.'.kartoteki');

    Route::prefix('kartoteki')->name($loc.'.kartoteki.')->group(function () {
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
};

Route::get('/', function (Request $request) {
    $pref = LandingLocalePreference::cookieValue($request);
    if ($pref !== null) {
        return redirect()->route(LandingLocalePreference::landingRouteNameForLocale($pref), [], 302);
    }

    $browser = LandingLocalePreference::preferredLocaleFromAcceptLanguage($request);
    if ($browser !== null) {
        return redirect()->route(LandingLocalePreference::landingRouteNameForLocale($browser), [], 302);
    }

    return redirect()->route('en.landing', [], 302);
})->middleware('admin.audit:nav')->name('home');

Route::redirect('/pl', '/pl/landing', 302);

Route::prefix('pl')->middleware('landing.locale:pl')->group(function () use ($showRejestracjaForm, $storeRejestracja, $registerLocaleAppRoutes): void {
    Route::get('/landing', fn () => view('landing.index'))
        ->middleware('admin.audit:nav')
        ->name('pl.landing');
    Route::get('/funkcje/{slug}', [LandingFunkcjaController::class, 'showPl'])
        ->where('slug', 'kartoteka|schemat|przeglad')
        ->middleware('admin.audit:nav')
        ->name('pl.landing.funkcja');
    Route::get('/polityka-prywatnosci', fn () => view('landing.polityka-prywatnosci'))
        ->middleware('admin.audit:nav')
        ->name('pl.polityka-prywatnosci');
    Route::get('/regulamin', fn () => view('landing.regulamin'))
        ->middleware('admin.audit:nav')
        ->name('pl.regulamin');
    Route::post('/zgoda-na-cookies', [CookieConsentController::class, 'store'])->name('pl.cookie.consent');
    Route::post('/landing/kontakt', [LandingContactController::class, 'store'])
        ->middleware('throttle:8,1')
        ->name('pl.landing.kontakt');
    Route::get('/cennik', fn () => view('cennik'))->name('pl.cennik');
    Route::get('/rejestracja', $showRejestracjaForm)
        ->middleware('admin.audit:registration_open')
        ->name('pl.rejestracja');
    Route::post('/rejestracja', $storeRejestracja)->name('pl.rejestracja.store');
    $registerLocaleAppRoutes('pl');
});

Route::prefix('en')->middleware('landing.locale:en')->group(function () use ($showRejestracjaForm, $storeRejestracja, $registerLocaleAppRoutes): void {
    Route::get('/landing', fn () => view('landing.index'))
        ->middleware('admin.audit:nav')
        ->name('en.landing');
    Route::get('/features/{slug}', [LandingFunkcjaController::class, 'showEn'])
        ->where('slug', 'directory|org-chart|overview')
        ->middleware('admin.audit:nav')
        ->name('en.landing.funkcja');
    Route::get('/privacy-policy', fn () => view('landing.privacy-en'))
        ->middleware('admin.audit:nav')
        ->name('en.privacy');
    Route::get('/terms-of-service', fn () => view('landing.terms-en'))
        ->middleware('admin.audit:nav')
        ->name('en.terms');
    Route::post('/landing/contact', [LandingContactController::class, 'store'])
        ->middleware('throttle:8,1')
        ->name('en.landing.contact');
    Route::post('/cookie-consent', [CookieConsentController::class, 'store'])->name('en.cookie.consent');
    Route::get('/cennik', fn () => view('cennik'))->name('en.cennik');
    Route::get('/rejestracja', $showRejestracjaForm)
        ->middleware('admin.audit:registration_open')
        ->name('en.rejestracja');
    Route::post('/rejestracja', $storeRejestracja)->name('en.rejestracja.store');
    $registerLocaleAppRoutes('en');
});

Route::redirect('/es', '/es/landing', 302);

Route::prefix('es')->middleware('landing.locale:es')->group(function () use ($showRejestracjaForm, $storeRejestracja, $registerLocaleAppRoutes): void {
    Route::get('/landing', fn () => view('landing.index'))
        ->middleware('admin.audit:nav')
        ->name('es.landing');
    Route::get('/funciones/{slug}', [LandingFunkcjaController::class, 'showEs'])
        ->where('slug', 'directorio|organigrama|vista-general')
        ->middleware('admin.audit:nav')
        ->name('es.landing.funkcja');
    Route::get('/politica-privacidad', fn () => view('landing.privacy-es'))
        ->middleware('admin.audit:nav')
        ->name('es.privacy');
    Route::get('/terminos', fn () => view('landing.terms-es'))
        ->middleware('admin.audit:nav')
        ->name('es.terms');
    Route::post('/landing/contacto', [LandingContactController::class, 'store'])
        ->middleware('throttle:8,1')
        ->name('es.landing.contact');
    Route::post('/consentimiento-cookies', [CookieConsentController::class, 'store'])->name('es.cookie.consent');
    Route::get('/cennik', fn () => view('cennik'))->name('es.cennik');
    Route::get('/rejestracja', $showRejestracjaForm)
        ->middleware('admin.audit:registration_open')
        ->name('es.rejestracja');
    Route::post('/rejestracja', $storeRejestracja)->name('es.rejestracja.store');
    $registerLocaleAppRoutes('es');
});

Route::redirect('/fr', '/fr/landing', 302);

Route::prefix('fr')->middleware('landing.locale:fr')->group(function () use ($showRejestracjaForm, $storeRejestracja, $registerLocaleAppRoutes): void {
    Route::get('/landing', fn () => view('landing.index'))
        ->middleware('admin.audit:nav')
        ->name('fr.landing');
    Route::get('/fonctions/{slug}', [LandingFunkcjaController::class, 'showFr'])
        ->where('slug', 'annuaire|organigramme|vue-ensemble')
        ->middleware('admin.audit:nav')
        ->name('fr.landing.funkcja');
    Route::get('/politique-de-confidentialite', fn () => view('landing.privacy-fr'))
        ->middleware('admin.audit:nav')
        ->name('fr.privacy');
    Route::get('/conditions', fn () => view('landing.terms-fr'))
        ->middleware('admin.audit:nav')
        ->name('fr.terms');
    Route::post('/landing/contact', [LandingContactController::class, 'store'])
        ->middleware('throttle:8,1')
        ->name('fr.landing.contact');
    Route::post('/consentement-cookies', [CookieConsentController::class, 'store'])->name('fr.cookie.consent');
    Route::get('/cennik', fn () => view('cennik'))->name('fr.cennik');
    Route::get('/rejestracja', $showRejestracjaForm)
        ->middleware('admin.audit:registration_open')
        ->name('fr.rejestracja');
    Route::post('/rejestracja', $storeRejestracja)->name('fr.rejestracja.store');
    $registerLocaleAppRoutes('fr');
});

Route::redirect('/de', '/de/landing', 302);

Route::prefix('de')->middleware('landing.locale:de')->group(function () use ($showRejestracjaForm, $storeRejestracja, $registerLocaleAppRoutes): void {
    Route::get('/landing', fn () => view('landing.index'))
        ->middleware('admin.audit:nav')
        ->name('de.landing');
    Route::get('/funktionen/{slug}', [LandingFunkcjaController::class, 'showDe'])
        ->where('slug', 'verzeichnis|organigramm|ueberblick')
        ->middleware('admin.audit:nav')
        ->name('de.landing.funkcja');
    Route::get('/datenschutz', fn () => view('landing.privacy-de'))
        ->middleware('admin.audit:nav')
        ->name('de.privacy');
    Route::get('/nutzungsbedingungen', fn () => view('landing.terms-de'))
        ->middleware('admin.audit:nav')
        ->name('de.terms');
    Route::post('/landing/kontakt', [LandingContactController::class, 'store'])
        ->middleware('throttle:8,1')
        ->name('de.landing.contact');
    Route::post('/cookie-einwilligung', [CookieConsentController::class, 'store'])->name('de.cookie.consent');
    Route::get('/cennik', fn () => view('cennik'))->name('de.cennik');
    Route::get('/rejestracja', $showRejestracjaForm)
        ->middleware('admin.audit:registration_open')
        ->name('de.rejestracja');
    Route::post('/rejestracja', $storeRejestracja)->name('de.rejestracja.store');
    $registerLocaleAppRoutes('de');
});

Route::post('/landing/kontakt', [LandingContactController::class, 'store'])
    ->middleware('throttle:8,1');
Route::post('/zgoda-na-cookies', [CookieConsentController::class, 'store']);

Route::redirect('/funkcje/{slug}', '/pl/funkcje/{slug}', 302)
    ->where('slug', 'kartoteka|schemat|przeglad');
Route::redirect('/polityka-prywatnosci', '/pl/polityka-prywatnosci', 302);
Route::redirect('/regulamin', '/pl/regulamin', 302);
Route::redirect('/cennik', '/pl/cennik', 302);
Route::get('/rejestracja', static fn () => redirect()->route('pl.rejestracja', ['plan' => request('plan', 'free')], 302));

Route::get('/login', static fn (Request $r) => redirect('/'.LandingLocalePreference::resolveLocaleForRequest($r).'/login', 302));
Route::post('/login', [LoginController::class, 'login']);

$legacyToLocalePath = static function (Request $request, string $suffix): RedirectResponse {
    $loc = AppUrl::uiLocaleFromRequest($request);
    $path = '/'.$loc.'/'.ltrim($suffix, '/');
    if ($request->getQueryString()) {
        $path .= '?'.$request->getQueryString();
    }

    return redirect($path, 302);
};

Route::get('/upgrade', static fn (Request $r) => $legacyToLocalePath($r, 'upgrade'));
Route::get('/upgrade/sukces', static fn (Request $r) => $legacyToLocalePath($r, 'upgrade/sukces'));
Route::get('/schemat', static fn (Request $r) => $legacyToLocalePath($r, 'schemat'));
Route::get('/przeglad', static fn (Request $r) => $legacyToLocalePath($r, 'przeglad'));
Route::get('/stanowiska', static fn (Request $r) => $legacyToLocalePath($r, 'stanowiska'));
Route::get('/stanowiska/siatka-wynagrodzen', static fn (Request $r) => $legacyToLocalePath($r, 'stanowiska/siatka-wynagrodzen'));
Route::get('/instrukcja', static fn (Request $r) => $legacyToLocalePath($r, 'instrukcja'));
Route::get('/ustawienia', static fn (Request $r) => $legacyToLocalePath($r, 'ustawienia'));
Route::get('/kartoteki', static fn (Request $r) => $legacyToLocalePath($r, 'kartoteki'));
Route::get('/wynagrodzenia', static fn (Request $r) => $legacyToLocalePath($r, 'wynagrodzenia'));

Route::any('/kartoteki/{any?}', static function (Request $request, ?string $any = null) {
    $base = 'kartoteki'.($any !== null && $any !== '' ? '/'.$any : '');
    $loc = AppUrl::uiLocaleFromRequest($request);
    $path = '/'.$loc.'/'.$base;
    if ($request->getQueryString()) {
        $path .= '?'.$request->getQueryString();
    }
    $status = ($request->isMethod('GET') || $request->isMethod('HEAD')) ? 302 : 307;

    return redirect($path, $status);
})->where('any', '.*');

Route::get('/upgrade/platnosc-stripe', [FullPlanPaymentController::class, 'start'])
    ->name('upgrade.stripe.start');

Route::get('/platnosc/full/dziekujemy', [FullPlanPaymentController::class, 'thankYou'])
    ->name('platnosc.full.dziekujemy');

Route::get('/{token}', [LoginController::class, 'loginViaLink'])
    ->where('token', '[a-zA-Z0-9]{15}')
    ->name('login.via.link');
