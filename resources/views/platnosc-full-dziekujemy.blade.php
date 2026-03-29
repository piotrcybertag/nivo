@extends('layouts.app')

@section('title', 'Płatność — plan Full — Nivo')

@section('content')
<div style="max-width: 36rem; margin: 0 auto; padding: 2rem 1rem;">
    @if($status === 'sukces')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">Dziękujemy za płatność</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem; line-height: 1.6;">Plan Full został aktywowany na koncie <strong>{{ $uzytkownik->imie_nazwisko }}</strong>. Jesteś z powrotem zalogowany — możesz korzystać z aplikacji bez limitu pracowników.</p>
        <p style="font-size: 0.9375rem; color: #065f46; margin-bottom: 1.5rem;">Sesja została odświeżona; nie musisz logować się ponownie.</p>
        <a href="{{ route('home') }}" style="display: inline-block; padding: 0.65rem 1.25rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 1rem;">Przejdź do aplikacji</a>
    @elseif($status === 'brak_klucza')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">Konfiguracja płatności</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem; line-height: 1.6;">Na serwerze nie ustawiono <code style="background: #f1f5f9; padding: 0.1rem 0.35rem; border-radius: 0.25rem;">STRIPE_SECRET_KEY</code>, więc nie można potwierdzić płatności automatycznie. Skontaktuj się z administratorem lub — jeśli jesteś zalogowany na planie Free — użyj strony upgrade i przycisku aktywacji (jeśli nadal jest dostępny).</p>
        <a href="{{ route('home') }}" style="color: #1e40af;">← Strona główna</a>
    @elseif($status === 'brak_sesji_stripe')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">Brak potwierdzenia z Stripe</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">W adresie strony powinien znaleźć się parametr <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">session_id</code> po przekierowaniu z płatności. Upewnij się, że w Stripe (Payment Link → After payment) ustawiono adres powrotu z placeholderem <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">{{ '{CHECKOUT_SESSION_ID}' }}</code>.</p>
        <a href="{{ route('home') }}" style="color: #1e40af;">← Strona główna</a>
    @elseif($status === 'blad_stripe')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">Komunikacja ze Stripe</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">Nie udało się zweryfikować sesji płatności. Spróbuj ponownie za chwilę lub napisz na kontakt podany na stronie.</p>
        <a href="{{ route('home') }}" style="color: #1e40af;">← Strona główna</a>
    @elseif($status === 'nieoplacone')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">Płatność niedokończona</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">Sesja Stripe nie ma statusu opłaconej płatności. Jeśli płaciłeś kartą, sprawdź skrzynkę e-mail lub ponów płatność z poziomu <a href="{{ route('upgrade') }}" style="color: #1e40af;">upgrade</a>.</p>
    @elseif($status === 'brak_powiazania')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">Brak powiązania z kontem</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">Płatność nie zawiera identyfikatora konta (link do Stripe powinien być otwarty z aplikacji przez „Wybierz Full”). Wróć do <a href="{{ route('upgrade') }}" style="color: #1e40af;">strony upgrade</a> i rozpocznij płatność ponownie.</p>
    @elseif($status === 'brak_uzytkownika')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">Nie znaleziono użytkownika</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">Skontaktuj się z pomocą techniczną podając datę płatności.</p>
        <a href="{{ route('home') }}" style="color: #1e40af;">← Strona główna</a>
    @else
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">Wystąpił problem</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">Spróbuj ponownie lub skontaktuj się z pomocą.</p>
        <a href="{{ route('home') }}" style="color: #1e40af;">← Strona główna</a>
    @endif
</div>
@endsection
