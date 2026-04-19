@extends('layouts.app')

@section('title', __('employees.kartoteki_title'))

@section('content')
    <div style="padding: 2rem 0;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">{{ __('employees.kartoteki_title') }}</h2>
        <p style="margin-top: 0.5rem; margin-bottom: 1.5rem; color: #4b5563;">{{ __('employees.kartoteki_intro') }}</p>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 0.5rem;">
                <a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.index') }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">{{ __('employees.kartoteki_employees') }}</a>
                <span style="color: #6b7280; font-size: 0.875rem;">{{ __('employees.kartoteki_employees_hint') }}</span>
            </li>
            <li style="margin-bottom: 0.5rem;">
                <a href="{{ \App\Support\AppUrl::route('wynagrodzenia.raport') }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">{{ __('app.wynagrodzenia_raport.kartoteki_link') }}</a>
                <span style="color: #6b7280; font-size: 0.875rem;">{{ __('app.wynagrodzenia_raport.kartoteki_hint') }}</span>
            </li>
        </ul>
    </div>
@endsection
