@extends('layouts.app')

@section('title', __('billing.upgrade_page_title'))

@section('content')
<div style="max-width: 36rem; margin: 0 auto; padding: 2rem 1rem;">
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1.5rem;">{{ __('billing.upgrade_heading') }}</h1>

    <div style="background: #fff; border: 2px solid #1e40af; border-radius: 0.75rem; padding: 1.75rem; box-shadow: 0 4px 12px rgba(30,64,175,0.12);">
        <div style="font-size: 1.25rem; font-weight: 700; color: #1e40af; margin-bottom: 0.5rem;">{{ __('billing.plan_full') }}</div>
        <div style="font-size: 1.125rem; font-weight: 600; color: #0f172a; margin-bottom: 0.5rem;">{{ __('billing.price_line') }}</div>
        <p style="font-size: 0.875rem; color: #64748b; margin: 0 0 1rem; line-height: 1.5;">{{ __('billing.paid_yearly') }}</p>
        <p style="font-size: 0.9375rem; color: #374151; margin: 0 0 1.5rem; line-height: 1.6;">{{ __('billing.upgrade_description') }}</p>
        <a href="{{ route('upgrade.stripe.start') }}" style="display: inline-block; padding: 0.65rem 1.5rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 1rem;">{{ __('billing.upgrade_cta') }}</a>
    </div>
</div>
@endsection
