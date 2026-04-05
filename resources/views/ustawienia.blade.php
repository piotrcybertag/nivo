@extends('layouts.app')

@section('title', __('settings.page_title'))

@section('content')
    <div style="max-width: 36rem; margin: 0 auto;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1.5rem;">{{ __('settings.heading') }}</h1>

        <div style="padding: 1.25rem; background: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb; margin-bottom: 1.25rem;">
            <h2 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.75rem;">{{ __('settings.plan_heading') }}</h2>
            <p style="margin: 0 0 0.5rem; font-size: 0.9375rem; color: #374151;">
                {{ __('settings.plan_current') }}
                <strong>
                    @if(($uzytkownik->plan ?? 'FREE') === 'FULL')
                        {{ __('settings.plan_label_full') }}
                    @else
                        {{ __('settings.plan_label_free') }}
                    @endif
                </strong>
            </p>
            @if(($uzytkownik->plan ?? 'FREE') === 'FREE')
                <p style="margin: 0 0 0.75rem; font-size: 0.875rem; color: #64748b;">{{ __('settings.plan_free_hint') }}</p>
                <a href="{{ \App\Support\AppUrl::route('upgrade') }}" style="display: inline-block; padding: 0.5rem 1rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem;">{{ __('settings.upgrade_full') }}</a>
            @else
                <p style="margin: 0; font-size: 0.875rem; color: #64748b;">{{ __('settings.plan_full_ok') }}</p>
            @endif
        </div>

        <div style="padding: 1.25rem; background: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
            <h2 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.75rem;">{{ __('settings.link_heading') }}</h2>
            @if(session('generated_login_link'))
                <p style="margin: 0 0 0.5rem; font-size: 0.875rem; color: #374151;">{{ __('settings.link_new') }}</p>
                <p style="margin: 0 0 1rem; word-break: break-all; font-size: 0.95rem;">
                    <a href="{{ session('generated_login_link') }}" style="color: #1e40af;">{{ session('generated_login_link') }}</a>
                </p>
            @elseif($uzytkownik->login_link_token)
                <p style="margin: 0 0 0.5rem; font-size: 0.875rem; color: #374151;">{{ __('settings.link_assigned') }}</p>
                <p style="margin: 0 0 0.5rem; word-break: break-all; font-size: 0.95rem;">
                    <a href="{{ url('/' . $uzytkownik->login_link_token) }}" style="color: #1e40af;">{{ url('/' . $uzytkownik->login_link_token) }}</a>
                </p>
            @endif
            <p style="margin: 0 0 1rem; font-size: 0.8125rem; color: #6b7280;">{{ __('settings.link_note') }}</p>
            <form method="POST" action="{{ \App\Support\AppUrl::route('ustawienia.generuj-link') }}">
                @csrf
                <button type="submit" style="padding: 0.5rem 1rem; background: #1e40af; color: #fff; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; cursor: pointer;">{{ $uzytkownik->login_link_token ? __('settings.regenerate_link') : __('settings.generate_link') }}</button>
            </form>
        </div>
    </div>
@endsection
