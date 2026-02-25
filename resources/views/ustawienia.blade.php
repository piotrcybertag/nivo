@extends('layouts.app')

@section('title', 'Ustawienia')

@section('content')
    <div style="max-width: 36rem; margin: 0 auto;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1.5rem;">Ustawienia</h1>

        <div style="padding: 1.25rem; background: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb; margin-bottom: 1.25rem;">
            <h2 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.75rem;">Twój plan</h2>
            <p style="margin: 0 0 0.5rem; font-size: 0.9375rem; color: #374151;">
                Aktualny plan: <strong>{{ $uzytkownik->plan ?? 'Free' }}</strong>
            </p>
            @if(($uzytkownik->plan ?? 'FREE') === 'FREE')
                <p style="margin: 0 0 0.75rem; font-size: 0.875rem; color: #64748b;">Plan Free: do 10 pracowników. Plan Full: bez limitu, 1 €/mies. (12 € rocznie).</p>
                <a href="{{ route('upgrade') }}" style="display: inline-block; padding: 0.5rem 1rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem;">Przejdź na plan Full</a>
            @else
                <p style="margin: 0; font-size: 0.875rem; color: #64748b;">Masz pełny dostęp bez limitu pracowników.</p>
            @endif
        </div>

        <div style="padding: 1.25rem; background: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
            <h2 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.75rem;">Twój link do logowania</h2>
            @if(session('generated_login_link'))
                <p style="margin: 0 0 0.5rem; font-size: 0.875rem; color: #374151;">Nowy link (możesz go skopiować i przekazać innym):</p>
                <p style="margin: 0 0 1rem; word-break: break-all; font-size: 0.95rem;">
                    <a href="{{ session('generated_login_link') }}" style="color: #1e40af;">{{ session('generated_login_link') }}</a>
                </p>
            @elseif($uzytkownik->login_link_token)
                <p style="margin: 0 0 0.5rem; font-size: 0.875rem; color: #374151;">Link przypisany do Twojego konta (możesz go skopiować i przekazać innym):</p>
                <p style="margin: 0 0 0.5rem; word-break: break-all; font-size: 0.95rem;">
                    <a href="{{ url('/' . $uzytkownik->login_link_token) }}" style="color: #1e40af;">{{ url('/' . $uzytkownik->login_link_token) }}</a>
                </p>
            @endif
            <p style="margin: 0 0 1rem; font-size: 0.8125rem; color: #6b7280;">Osoba, która wejdzie w ten link, zobaczy Schemat i Przegląd w Twoim imieniu, bez dostępu do kartoteki Pracownicy.</p>
            <form method="POST" action="{{ route('ustawienia.generuj-link') }}">
                @csrf
                <button type="submit" style="padding: 0.5rem 1rem; background: #1e40af; color: #fff; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; cursor: pointer;">{{ $uzytkownik->login_link_token ? 'Wygeneruj nowy link' : 'Generuj link' }}</button>
            </form>
        </div>
    </div>
@endsection
