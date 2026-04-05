@extends('layouts.app')

@section('title', __('billing.success_return_page_title'))

@section('content')
<div style="max-width: 36rem; margin: 0 auto; padding: 2rem 1rem;">
    @if($status === 'sukces')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">{{ __('billing.return.sukces.title') }}</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem; line-height: 1.6;">{!! __('billing.return.sukces.p1', ['name' => e($uzytkownik->imie_nazwisko)]) !!}</p>
        <p style="font-size: 0.9375rem; color: #065f46; margin-bottom: 1.5rem;">{{ __('billing.return.sukces.p2') }}</p>
        <a href="{{ \App\Support\AppUrl::route('schemat') }}" style="display: inline-block; padding: 0.65rem 1.25rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 1rem;">{{ __('billing.return.sukces.cta') }}</a>
    @elseif($status === 'brak_klucza')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">{{ __('billing.return.brak_klucza.title') }}</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem; line-height: 1.6;">{!! __('billing.return.brak_klucza.p') !!}</p>
        <a href="{{ \App\Support\LandingAlternateUrls::homeUrl() }}" style="color: #1e40af;">{{ __('billing.return.home_link') }}</a>
    @elseif($status === 'brak_sesji_stripe')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">{{ __('billing.return.brak_sesji_stripe.title') }}</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">{!! __('billing.return.brak_sesji_stripe.p') !!}</p>
        <a href="{{ \App\Support\LandingAlternateUrls::homeUrl() }}" style="color: #1e40af;">{{ __('billing.return.home_link') }}</a>
    @elseif($status === 'blad_stripe')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">{{ __('billing.return.blad_stripe.title') }}</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">{{ __('billing.return.blad_stripe.p') }}</p>
        <a href="{{ \App\Support\LandingAlternateUrls::homeUrl() }}" style="color: #1e40af;">{{ __('billing.return.home_link') }}</a>
    @elseif($status === 'nieoplacone')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">{{ __('billing.return.nieoplacone.title') }}</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">{{ __('billing.return.nieoplacone.before') }}<a href="{{ \App\Support\AppUrl::route('upgrade') }}" style="color: #1e40af;">{{ __('billing.return.nieoplacone.link') }}</a>{{ __('billing.return.nieoplacone.after') }}</p>
    @elseif($status === 'brak_powiazania')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">{{ __('billing.return.brak_powiazania.title') }}</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">{{ __('billing.return.brak_powiazania.before') }}<a href="{{ \App\Support\AppUrl::route('upgrade') }}" style="color: #1e40af;">{{ __('billing.return.brak_powiazania.link') }}</a>{{ __('billing.return.brak_powiazania.after') }}</p>
    @elseif($status === 'brak_uzytkownika')
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">{{ __('billing.return.brak_uzytkownika.title') }}</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">{{ __('billing.return.brak_uzytkownika.p') }}</p>
        <a href="{{ \App\Support\LandingAlternateUrls::homeUrl() }}" style="color: #1e40af;">{{ __('billing.return.home_link') }}</a>
    @else
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1rem;">{{ __('billing.return.default.title') }}</h1>
        <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">{{ __('billing.return.default.p') }}</p>
        <a href="{{ \App\Support\LandingAlternateUrls::homeUrl() }}" style="color: #1e40af;">{{ __('billing.return.home_link') }}</a>
    @endif
</div>
@endsection
