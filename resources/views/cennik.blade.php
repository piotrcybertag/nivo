@extends('layouts.app')

@section('title', __('pricing.page_title'))

@section('content')
<div class="landing" style="max-width: 56rem; margin: 0 auto; padding: 2rem 1rem 4rem;">
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; text-align: center; margin-bottom: 2rem;">{{ __('pricing.heading') }}</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; justify-items: center;">
        <div style="background: #fff; border: 2px solid #e2e8f0; border-radius: 0.75rem; padding: 1.75rem; width: 100%; max-width: 280px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <div style="font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">Free</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-bottom: 1rem;">0 €</div>
            <p style="font-size: 0.9375rem; color: #64748b; margin: 0 0 1.25rem; line-height: 1.5;">{{ __('pricing.free_desc') }}</p>
            <a href="{{ \App\Support\LandingAlternateUrls::rejestracjaUrl('free') }}" style="display: inline-block; padding: 0.6rem 1.25rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.9375rem;">{{ __('pricing.choose_free') }}</a>
        </div>
        <div style="background: #fff; border: 2px solid #1e40af; border-radius: 0.75rem; padding: 1.75rem; width: 100%; max-width: 280px; text-align: center; box-shadow: 0 4px 12px rgba(30,64,175,0.15);">
            <div style="font-size: 1.25rem; font-weight: 700; color: #1e40af; margin-bottom: 0.25rem;">Full</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #1e40af; margin-bottom: 0.25rem;">{{ __('billing.price_line') }}</div>
            <p style="font-size: 0.875rem; color: #64748b; margin: 0 0 1rem; line-height: 1.5;">{{ __('pricing.paid_yearly') }}</p>
            <p style="font-size: 0.9375rem; color: #64748b; margin: 0 0 1.25rem; line-height: 1.5;">{{ __('pricing.full_desc') }}</p>
            <a href="{{ \App\Support\LandingAlternateUrls::rejestracjaUrl('full') }}" style="display: inline-block; padding: 0.6rem 1.25rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.9375rem;">{{ __('pricing.choose_full') }}</a>
        </div>
    </div>
</div>
@endsection
