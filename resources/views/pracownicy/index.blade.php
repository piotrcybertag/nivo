@extends('layouts.app')

@section('title', 'Pracownicy')

@section('content')
    <style>
        .pracownik-akcja-link:hover, .pracownik-akcja-btn:hover { opacity: 0.8; background: rgba(0,0,0,0.06); }
    </style>
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin: 0;">Pracownicy</h1>
        @if($canAddPracownik)
            <a href="{{ route('kartoteki.pracownicy.create') }}" style="display: inline-block; padding: 0.5rem 1rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">Dodaj pracownika</a>
        @else
            <span style="font-size: 0.875rem; color: #6b7280;">Limit planu Free ({{ $limitFree }} pracowników). <a href="{{ route('ustawienia') }}" style="color: #1e40af;">Przejdź na Full w Ustawieniach</a>.</span>
        @endif
    </div>

    @if (session('success'))
        <p style="padding: 0.75rem 1rem; background: #d1fae8; color: #065f46; border-radius: 0.375rem; margin-bottom: 1rem;">{{ session('success') }}</p>
    @endif
    @if (session('error'))
        <p style="padding: 0.75rem 1rem; background: #fee2e2; color: #991b1b; border-radius: 0.375rem; margin-bottom: 1rem;">{{ session('error') }}</p>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 0.5rem;">
            <thead>
                <tr style="background: #f3f4f6; border-bottom: 2px solid #e5e7eb;">
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Id</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Imię</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Nazwisko</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Stanowisko</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Szef</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">Szef matrix</th>
                    <th style="text-align: right; padding: 0.75rem 1rem; font-weight: 600;">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pracownicy as $p)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 0.75rem 1rem;">{{ $p->id }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->imie }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->nazwisko }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->stanowisko }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->szef ? $p->szef->imie_nazwisko : '—' }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->szefMatrix ? $p->szefMatrix->imie_nazwisko : '—' }}</td>
                        <td style="padding: 0.75rem 1rem; text-align: right; white-space: nowrap;">
                            <a href="{{ route('kartoteki.pracownicy.show', $p) }}" title="Szczegóły" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; color: #2563eb; text-decoration: none; margin-right: 0.25rem; border-radius: 0.25rem;" class="pracownik-akcja-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <a href="{{ route('kartoteki.pracownicy.edit', $p) }}" title="Edytuj" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; color: #2563eb; text-decoration: none; margin-right: 0.25rem; border-radius: 0.25rem;" class="pracownik-akcja-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('kartoteki.pracownicy.destroy', $p) }}" method="POST" style="display: inline;" onsubmit="return confirm('Czy na pewno usunąć tego pracownika?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Usuń" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: none; border: none; color: #dc2626; cursor: pointer; padding: 0; border-radius: 0.25rem;" class="pracownik-akcja-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 2rem; text-align: center; color: #6b7280;">Brak pracowników. @if($canAddPracownik)<a href="{{ route('kartoteki.pracownicy.create') }}" style="color: #2563eb;">Dodaj pierwszego</a>.@else Dodaj pracowników po przejściu na plan Full.@endif</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pracownicy->hasPages())
        <div style="margin-top: 1.5rem;">{{ $pracownicy->links() }}</div>
    @endif
@endsection
