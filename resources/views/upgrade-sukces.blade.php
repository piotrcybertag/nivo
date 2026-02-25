@extends('layouts.app')

@section('title', 'Płatność zakończona — Nivo')

@section('content')
<div style="max-width: 36rem; margin: 0 auto; padding: 2rem 1rem;">
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">Dziękujemy za płatność</h1>
    <p style="font-size: 1rem; color: #374151; margin-bottom: 1.5rem;">Płatność za plan Full została przyjęta.</p>

    @if(session('uzytkownik_id') && !session('login_via_link') && session('uzytkownik_plan') === 'FREE')
        <p style="font-size: 0.9375rem; color: #374151; margin-bottom: 1rem;">Kliknij poniżej, aby włączyć plan Full w swoim koncie:</p>
        <form method="POST" action="{{ route('upgrade.store') }}" style="margin-bottom: 1.5rem;">
            @csrf
            <button type="submit" style="padding: 0.65rem 1.5rem; background: #1e40af; color: #fff; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 1rem; cursor: pointer;">Aktywuj plan Full</button>
        </form>
    @elseif(session('uzytkownik_plan') === 'FULL')
        <p style="font-size: 0.9375rem; color: #065f46; margin-bottom: 1rem;">Twój plan Full jest już aktywny.</p>
    @else
        <p style="font-size: 0.9375rem; color: #64748b; margin-bottom: 1rem;">Zaloguj się na swoje konto, aby aktywować plan Full (lub wróć później — możesz wtedy wejść w link „Upgrade” w menu).</p>
    @endif

    <a href="{{ route('home') }}" style="display: inline-block; padding: 0.5rem 1rem; color: #1e40af; text-decoration: none; font-size: 0.9375rem;">← Wróć do strony głównej</a>
</div>
@endsection
