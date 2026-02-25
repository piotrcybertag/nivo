@extends('layouts.app')

@section('title', 'Użytkownik: ' . $uzytkownik->imie_nazwisko)

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('kartoteki.uzytkownicy.index') }}" style="color: #2563eb; text-decoration: none;">← Powrót do listy</a>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin: 0;">{{ $uzytkownik->imie_nazwisko }}</h1>
        <div>
            <a href="{{ route('kartoteki.uzytkownicy.edit', $uzytkownik) }}" style="display: inline-block; padding: 0.5rem 1rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">Edytuj</a>
        </div>
    </div>

    <div style="background: #fff; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); max-width: 28rem;">
        <dl style="margin: 0; display: grid; gap: 0.75rem;">
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Id</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $uzytkownik->id }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Email</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $uzytkownik->email }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Imię i nazwisko</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $uzytkownik->imie_nazwisko }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Typ</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $uzytkownik->typ }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Plan</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $uzytkownik->plan ?? '—' }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Hasło</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $uzytkownik->password ? '••••••••' : '—' }}</dd>
            </div>
        </dl>
    </div>
@endsection
