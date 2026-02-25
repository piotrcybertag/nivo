@extends('layouts.app')

@section('title', 'Cennik — Nivo')

@section('content')
<div class="landing" style="max-width: 56rem; margin: 0 auto; padding: 2rem 1rem 4rem;">
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; text-align: center; margin-bottom: 2rem;">Wybierz plan</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; justify-items: center;">
        <div style="background: #fff; border: 2px solid #e2e8f0; border-radius: 0.75rem; padding: 1.75rem; width: 100%; max-width: 280px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <div style="font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">Free</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-bottom: 1rem;">Za darmo</div>
            <p style="font-size: 0.9375rem; color: #64748b; margin: 0 0 1.25rem; line-height: 1.5;">Do 10 pracowników w kartotece. Schemat i przegląd bez ograniczeń.</p>
            <a href="{{ route('rejestracja', ['plan' => 'free']) }}" style="display: inline-block; padding: 0.6rem 1.25rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.9375rem;">Wybierz Free</a>
        </div>
        <div style="background: #fff; border: 2px solid #1e40af; border-radius: 0.75rem; padding: 1.75rem; width: 100%; max-width: 280px; text-align: center; box-shadow: 0 4px 12px rgba(30,64,175,0.15);">
            <div style="font-size: 1.25rem; font-weight: 700; color: #1e40af; margin-bottom: 0.25rem;">Full</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #1e40af; margin-bottom: 0.25rem;">1 € / miesiąc</div>
            <p style="font-size: 0.875rem; color: #64748b; margin: 0 0 1rem; line-height: 1.5;">Płatne rocznie (12 €).</p>
            <p style="font-size: 0.9375rem; color: #64748b; margin: 0 0 1.25rem; line-height: 1.5;">Bez limitu pracowników. Pełna kartoteka, schemat i przegląd.</p>
            <a href="{{ route('rejestracja', ['plan' => 'full']) }}" style="display: inline-block; padding: 0.6rem 1.25rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.9375rem;">Wybierz Full</a>
        </div>
    </div>
</div>
@endsection
