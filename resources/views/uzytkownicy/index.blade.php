@extends('layouts.app')

@section('title', 'Użytkownicy')

@section('content')
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin: 0;">Użytkownicy</h1>
        <a href="{{ route('kartoteki.uzytkownicy.create') }}" style="display: inline-block; padding: 0.5rem 1rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">Dodaj użytkownika</a>
    </div>

    @if (session('success'))
        <p style="padding: 0.75rem 1rem; background: #d1fae8; color: #065f46; border-radius: 0.375rem; margin-bottom: 1rem;">{{ session('success') }}</p>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 0.5rem;">
            <thead>
                <tr style="background: #f3f4f6; border-bottom: 2px solid #e5e7eb;">
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Id</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Email</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Imię i nazwisko</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Typ</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Plan</th>
                    <th style="text-align: right; padding: 0.75rem 1rem; font-weight: 600;">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse($uzytkownicy as $u)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 0.75rem 1rem;">{{ $u->id }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $u->email }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $u->imie_nazwisko }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $u->typ }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $u->plan ?? '—' }}</td>
                        <td style="padding: 0.75rem 1rem; text-align: right;">
                            <a href="{{ route('kartoteki.uzytkownicy.show', $u) }}" style="color: #2563eb; text-decoration: none; margin-right: 0.5rem;">Szczegóły</a>
                            <a href="{{ route('kartoteki.uzytkownicy.edit', $u) }}" style="color: #2563eb; text-decoration: none; margin-right: 0.5rem;">Edytuj</a>
                            <form action="{{ route('kartoteki.uzytkownicy.destroy', $u) }}" method="POST" style="display: inline;" onsubmit="return confirm('Czy na pewno usunąć tego użytkownika?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; padding: 0;">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 2rem; text-align: center; color: #6b7280;">Brak użytkowników. <a href="{{ route('kartoteki.uzytkownicy.create') }}" style="color: #2563eb;">Dodaj pierwszego</a>.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($uzytkownicy->hasPages())
        <div style="margin-top: 1.5rem;">{{ $uzytkownicy->links() }}</div>
    @endif
@endsection
