@extends('layouts.app')

@section('title', 'Edytuj pracownika')

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('kartoteki.pracownicy.index') }}" style="color: #2563eb; text-decoration: none;">← Powrót do listy</a>
    </div>
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1.5rem;">Edytuj pracownika</h1>

    <form action="{{ route('kartoteki.pracownicy.update', $pracownik) }}" method="POST" style="max-width: 28rem;">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 1rem;">
            <label for="imie" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Imię *</label>
            <input type="text" name="imie" id="imie" value="{{ old('imie', $pracownik->imie) }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('imie')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="nazwisko" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Nazwisko *</label>
            <input type="text" name="nazwisko" id="nazwisko" value="{{ old('nazwisko', $pracownik->nazwisko) }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('nazwisko')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="stanowisko" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Stanowisko *</label>
            <input type="text" name="stanowisko" id="stanowisko" value="{{ old('stanowisko', $pracownik->stanowisko) }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('stanowisko')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="id_szefa" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Szef (linia)</label>
            <select name="id_szefa" id="id_szefa" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="">— brak —</option>
                @foreach($pracownicy as $p)
                    <option value="{{ $p->id }}" {{ old('id_szefa', $pracownik->id_szefa) == $p->id ? 'selected' : '' }}>{{ $p->imie_nazwisko }} ({{ $p->stanowisko }})</option>
                @endforeach
            </select>
            @error('id_szefa')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label for="szef_matrix" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Szef matrix</label>
            <select name="szef_matrix" id="szef_matrix" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="">— brak —</option>
                @foreach($pracownicy as $p)
                    <option value="{{ $p->id }}" {{ old('szef_matrix', $pracownik->szef_matrix) == $p->id ? 'selected' : '' }}>{{ $p->imie_nazwisko }} ({{ $p->stanowisko }})</option>
                @endforeach
            </select>
            @error('szef_matrix')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" style="padding: 0.5rem 1.25rem; background: #1e40af; color: #fff; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">Zapisz zmiany</button>
    </form>
@endsection
