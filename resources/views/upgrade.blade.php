@extends('layouts.app')

@section('title', 'Upgrade — Nivo')

@section('content')
<div style="max-width: 36rem; margin: 0 auto; padding: 2rem 1rem;">
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1.5rem;">Przejdź na plan Full</h1>

    @if (session('success'))
        <p style="padding: 0.75rem 1rem; background: #d1fae8; color: #065f46; border-radius: 0.375rem; margin-bottom: 1.5rem;">{{ session('success') }}</p>
    @endif

    <div style="background: #fff; border: 2px solid #1e40af; border-radius: 0.75rem; padding: 1.75rem; box-shadow: 0 4px 12px rgba(30,64,175,0.12);">
        <div style="font-size: 1.25rem; font-weight: 700; color: #1e40af; margin-bottom: 0.5rem;">Plan Full</div>
        <div style="font-size: 1.125rem; font-weight: 600; color: #0f172a; margin-bottom: 0.5rem;">1 € / miesiąc</div>
        <p style="font-size: 0.875rem; color: #64748b; margin: 0 0 1rem; line-height: 1.5;">Płatne rocznie (12 €).</p>
        <p style="font-size: 0.9375rem; color: #374151; margin: 0 0 1.5rem; line-height: 1.6;">Bez limitu pracowników. Pełna kartoteka, schemat i przegląd — bez ograniczenia do 10 osób.</p>
        <a href="{{ config('services.stripe.payment_link') }}" target="_blank" rel="noopener noreferrer" style="display: inline-block; padding: 0.65rem 1.5rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 1rem;">Wybierz Full</a>
    </div>
</div>
@endsection
