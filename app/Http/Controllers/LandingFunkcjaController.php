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
}
