@extends('layouts.app')

@section('title', 'Nivo — Schemat organizacyjny')

@section('content')
<div class="landing">
    <div class="landing-hero">
        <img src="{{ asset('storage/nivo.png') }}" alt="Nivo" class="landing-hero-logo">
        <div class="landing-hero-badge">Schemat organizacyjny</div>
        <h1 class="landing-title">Nivo</h1>
        <p class="landing-tagline">Prowadź strukturę firmy w jednym miejscu. Kartoteka pracowników, drzewo zależności i przejrzysty przegląd — w przeglądarce.</p>
        @if(session('uzytkownik_id'))
            <a href="{{ route('schemat') }}" class="landing-cta">Otwórz schemat</a>
        @else
            <a href="{{ route('login') }}" class="landing-cta">Zaloguj się</a>
        @endif
    </div>

    <div class="landing-features">
        <div class="landing-card">
            <div class="landing-card-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <h3 class="landing-card-title">Pracownicy</h3>
            <p class="landing-card-text">Kartoteka z imieniem, nazwiskiem, stanowiskiem oraz szefem w linii i matrix. Dodawanie, edycja i usuwanie w kilku kliknięciach.</p>
        </div>
        <div class="landing-card">
            <div class="landing-card-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4"/><path d="M12 18v4"/><path d="m4.93 4.93 2.83 2.83"/><path d="m16.24 16.24 2.83 2.83"/><path d="M2 12h4"/><path d="M18 12h4"/><path d="m4.93 19.07 2.83-2.83"/><path d="m16.24 7.76 2.83-2.83"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <h3 class="landing-card-title">Schemat</h3>
            <p class="landing-card-text">Struktura w formie drzewa. Kliknij w pracownika, aby zobaczyć podwładnych. Wyszukiwarka w panelu bocznym.</p>
        </div>
        <div class="landing-card">
            <div class="landing-card-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
            </div>
            <h3 class="landing-card-title">Przegląd</h3>
            <p class="landing-card-text">Całe drzewo na jednym ekranie. Zoom i przewijanie — wygodnie do prezentacji lub wydruku.</p>
        </div>
    </div>

    <div class="landing-footer">
        <p>Zaloguj się, aby korzystać z kartoteki, schematu i przeglądu.</p>
    </div>
</div>

<style>
    .landing { max-width: 56rem; margin: 0 auto; padding: 2rem 1rem 4rem; }
    .landing-hero { text-align: center; padding: 3rem 0 4rem; }
    .landing-hero-logo { display: block; margin: 0 auto 1.5rem; width: 120px; height: 120px; object-fit: contain; }
    .landing-hero-badge { display: inline-block; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: #1e40af; background: #eff6ff; padding: 0.35rem 0.75rem; border-radius: 999px; margin-bottom: 1.25rem; }
    .landing-title { font-size: clamp(2.25rem, 6vw, 3.5rem); font-weight: 700; color: #0f172a; letter-spacing: -0.02em; line-height: 1.15; margin: 0 0 1rem; }
    .landing-tagline { font-size: 1.125rem; color: #475569; line-height: 1.65; max-width: 32rem; margin: 0 auto 2rem; }
    .landing-cta { display: inline-block; font-size: 1rem; font-weight: 600; color: #fff; background: #1e40af; padding: 0.75rem 1.75rem; border-radius: 0.5rem; text-decoration: none; box-shadow: 0 2px 8px rgba(30, 64, 175, 0.35); transition: background 0.2s, transform 0.15s; }
    .landing-cta:hover { background: #1e3a8a; transform: translateY(-1px); }
    .landing-features { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; margin-bottom: 3rem; }
    .landing-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04); transition: border-color 0.2s, box-shadow 0.2s; }
    .landing-card:hover { border-color: #cbd5e1; box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
    .landing-card-icon { color: #1e40af; margin-bottom: 1rem; }
    .landing-card-title { font-size: 1.125rem; font-weight: 600; color: #0f172a; margin: 0 0 0.5rem; }
    .landing-card-text { font-size: 0.9375rem; color: #64748b; line-height: 1.55; margin: 0; }
    .landing-footer { text-align: center; font-size: 0.875rem; color: #94a3b8; }
</style>
@endsection
