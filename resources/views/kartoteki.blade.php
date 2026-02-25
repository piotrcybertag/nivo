@extends('layouts.app')

@section('title', 'Kartoteki')

@section('content')
    <div style="padding: 2rem 0;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">Kartoteki</h2>
        <p style="margin-top: 0.5rem; margin-bottom: 1.5rem; color: #4b5563;">Wybierz kartotekę do przeglądania lub edycji.</p>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 0.5rem;">
                <a href="{{ route('kartoteki.pracownicy.index') }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">Pracownicy</a>
                <span style="color: #6b7280; font-size: 0.875rem;"> — imię, nazwisko, stanowisko, szef</span>
            </li>
        </ul>
    </div>
@endsection
