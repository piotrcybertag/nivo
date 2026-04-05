@extends('layouts.app')

@section('title', __('users.edit_title'))

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ \App\Support\AppUrl::route('kartoteki.uzytkownicy.index') }}" style="color: #2563eb; text-decoration: none;">{{ __('users.back_to_list') }}</a>
    </div>
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1.5rem;">{{ __('users.edit_title') }}</h1>

    <form action="{{ \App\Support\AppUrl::route('kartoteki.uzytkownicy.update', $uzytkownik) }}" method="POST" style="max-width: 28rem;">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 1rem;">
            <label for="email" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('users.label_email') }} *</label>
            <input type="email" name="email" id="email" value="{{ old('email', $uzytkownik->email) }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('email')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="password" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('users.label_password_new') }}</label>
            <input type="password" name="password" id="password" autocomplete="new-password"
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;" placeholder="{{ __('users.placeholder_password_unchanged') }}">
            @error('password')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="password_confirmation" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('users.label_password_confirm') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="imie_nazwisko" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('users.label_full_name') }} *</label>
            <input type="text" name="imie_nazwisko" id="imie_nazwisko" value="{{ old('imie_nazwisko', $uzytkownik->imie_nazwisko) }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('imie_nazwisko')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="typ" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('users.label_type') }} *</label>
            <input type="text" name="typ" id="typ" value="{{ old('typ', $uzytkownik->typ) }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('typ')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label for="plan" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('users.label_plan') }}</label>
            <select name="plan" id="plan" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="">{{ __('users.emdash') }}</option>
                <option value="FREE" {{ old('plan', $uzytkownik->plan) === 'FREE' ? 'selected' : '' }}>Free</option>
                <option value="FULL" {{ old('plan', $uzytkownik->plan) === 'FULL' ? 'selected' : '' }}>Full</option>
            </select>
            @error('plan')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" style="padding: 0.5rem 1.25rem; background: #1e40af; color: #fff; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">{{ __('users.save_changes') }}</button>
    </form>

    <div style="margin-top: 2rem; padding: 1.25rem; background: #f3f4f6; border-radius: 0.5rem; border: 1px solid #e5e7eb; max-width: 28rem;">
        <h2 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.75rem;">{{ __('users.login_link_heading') }}</h2>
        @if (session('generated_login_link'))
            <p style="margin: 0 0 0.5rem; font-size: 0.875rem; color: #065f46;">{{ __('users.login_link_generated_hint') }}</p>
            <p style="margin: 0 0 1rem; word-break: break-all; font-size: 0.9rem;"><a href="{{ session('generated_login_link') }}" style="color: #1e40af;">{{ session('generated_login_link') }}</a></p>
        @elseif ($uzytkownik->login_link_token)
            <p style="margin: 0 0 0.5rem; font-size: 0.875rem;">{{ __('users.login_link_current') }}</p>
            <p style="margin: 0 0 1rem; word-break: break-all; font-size: 0.9rem;"><a href="{{ url('/' . $uzytkownik->login_link_token) }}" style="color: #1e40af;">{{ url('/' . $uzytkownik->login_link_token) }}</a></p>
        @else
            <p style="margin: 0 0 1rem; font-size: 0.875rem; color: #6b7280;">{{ __('users.login_link_empty_hint') }}</p>
        @endif
        <form method="POST" action="{{ \App\Support\AppUrl::route('kartoteki.uzytkownicy.generate-link', $uzytkownik) }}" style="display: inline;">
            @csrf
            <button type="submit" style="padding: 0.5rem 1rem; background: #374151; color: #fff; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">{{ __('users.generate_link') }}</button>
        </form>
    </div>
@endsection
