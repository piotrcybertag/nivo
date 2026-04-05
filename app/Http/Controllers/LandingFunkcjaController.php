<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class LandingFunkcjaController extends Controller
{
    private const PL = ['kartoteka', 'schemat', 'przeglad'];

    /** @var array<string, string> */
    private const EN_TO_INTERNAL = [
        'directory' => 'kartoteka',
        'org-chart' => 'schemat',
        'overview' => 'przeglad',
    ];

    /** @var array<string, string> */
    private const ES_TO_INTERNAL = [
        'directorio' => 'kartoteka',
        'organigrama' => 'schemat',
        'vista-general' => 'przeglad',
    ];

    /** @var array<string, string> */
    private const FR_TO_INTERNAL = [
        'annuaire' => 'kartoteka',
        'organigramme' => 'schemat',
        'vue-ensemble' => 'przeglad',
    ];

    /** @var array<string, string> */
    private const DE_TO_INTERNAL = [
        'verzeichnis' => 'kartoteka',
        'organigramm' => 'schemat',
        'ueberblick' => 'przeglad',
    ];

    public function showPl(string $slug): View
    {
        if (! in_array($slug, self::PL, true)) {
            abort(404);
        }

        return view('landing.funkcja', ['pageKey' => $slug]);
    }

    public function showEn(string $slug): View
    {
        $pageKey = self::EN_TO_INTERNAL[$slug] ?? null;
        if ($pageKey === null) {
            abort(404);
        }

        return view('landing.funkcja', ['pageKey' => $pageKey]);
    }

    public function showEs(string $slug): View
    {
        $pageKey = self::ES_TO_INTERNAL[$slug] ?? null;
        if ($pageKey === null) {
            abort(404);
        }

        return view('landing.funkcja', ['pageKey' => $pageKey]);
    }

    public function showFr(string $slug): View
    {
        $pageKey = self::FR_TO_INTERNAL[$slug] ?? null;
        if ($pageKey === null) {
            abort(404);
        }

        return view('landing.funkcja', ['pageKey' => $pageKey]);
    }

    public function showDe(string $slug): View
    {
        $pageKey = self::DE_TO_INTERNAL[$slug] ?? null;
        if ($pageKey === null) {
            abort(404);
        }

        return view('landing.funkcja', ['pageKey' => $pageKey]);
    }
}
