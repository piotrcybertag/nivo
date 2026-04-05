@extends('layouts.app')

@php
    use App\Support\LandingAlternateUrls;
@endphp

@section('title', __('registration.page_title'))

@section('content')
<div style="max-width: 28rem; margin: 0 auto; padding: 2rem 1rem;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ LandingAlternateUrls::registrationBackUrl() }}" style="color: #2563eb; text-decoration: none;">{{ __('registration.back') }}</a>
    </div>
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 0.5rem;">{{ __('registration.heading') }}</h1>
    <p style="font-size: 0.9375rem; color: #64748b; margin-bottom: 1.5rem;">
        {{ __('registration.plan_intro') }} <strong>{{ $plan === 'full' ? __('registration.plan_full') : __('registration.plan_free') }}</strong>
        @if($plan !== 'full')
            <span style="display: block; margin-top: 0.375rem; font-size: 0.875rem; color: #047857; font-weight: 500;">{{ __('registration.plan_free_no_card') }}</span>
        @endif
    </p>

    @if($plan === 'full')
        <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1.5rem;">
            <p style="margin: 0 0 0.5rem; font-size: 0.9375rem; color: #92400e; font-weight: 600;">{{ __('registration.full_notice_title') }}</p>
            <p style="margin: 0 0 1rem; font-size: 0.875rem; color: #78350f; line-height: 1.5;">
                {{ __('registration.full_notice_line1') }}
                <strong>{{ __('registration.full_notice_settings') }}</strong>
                {{ __('registration.full_notice_arrow') }}
                <strong>{{ __('registration.full_notice_upgrade') }}</strong>
                {{ __('registration.full_notice_line2') }}
            </p>
            <a href="{{ LandingAlternateUrls::rejestracjaUrl('free') }}" style="display: inline-block; padding: 0.6rem 1.25rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.9375rem;">{{ __('registration.full_cta_free') }}</a>
        </div>
    @else
    <form action="{{ route(LandingAlternateUrls::rejestracjaStoreRouteName()) }}" method="POST" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1.5rem;">
        @csrf
        <input type="hidden" name="plan" value="{{ $plan }}">
        <div style="margin-bottom: 1rem;">
            <label for="email" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('registration.label_email') }} *</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
            @error('email')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="imie_nazwisko" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('registration.label_name') }} *</label>
            <input type="text" name="imie_nazwisko" id="imie_nazwisko" value="{{ old('imie_nazwisko') }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
            @error('imie_nazwisko')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="organizacja" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('registration.label_org') }} *</label>
            <input type="text" name="organizacja" id="organizacja" value="{{ old('organizacja') }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;" placeholder="{{ __('registration.org_placeholder') }}">
            @error('organizacja')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
            <p style="margin: 0.25rem 0 0; font-size: 0.8125rem; color: #64748b;">{{ __('registration.org_hint') }}</p>
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="password" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('registration.label_password') }} *</label>
            <input type="password" name="password" id="password" required minlength="6" autocomplete="new-password"
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
            @error('password')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1.25rem;">
            <label for="password_confirmation" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('registration.label_password_confirmation') }} *</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="6" autocomplete="new-password"
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
        </div>
        <button type="submit" style="padding: 0.6rem 1.25rem; background: #1e40af; color: #fff; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">{{ __('registration.submit') }}</button>
    </form>
    @endif
</div>
@endsection
