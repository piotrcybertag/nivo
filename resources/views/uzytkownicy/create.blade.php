@extends('layouts.app')

@section('title', 'Dodaj użytkownika')

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('kartoteki.uzytkownicy.index') }}" style="color: #2563eb; text-decoration: none;">← Powrót do listy</a>
    </div>
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1.5rem;">Dodaj użytkownika</h1>

    <form action="{{ route('kartoteki.uzytkownicy.store') }}" method="POST" style="max-width: 28rem;">
        @csrf
        <div style="margin-bottom: 1rem;">
            <label for="email" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Email *</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('email')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="password" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Hasło *</label>
            <input type="password" name="password" id="password" required autocomplete="new-password"
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('password')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="password_confirmation" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Potwierdź hasło *</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="imie_nazwisko" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Imię i nazwisko *</label>
            <input type="text" name="imie_nazwisko" id="imie_nazwisko" value="{{ old('imie_nazwisko') }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('imie_nazwisko')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="typ" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Typ *</label>
            <input type="text" name="typ" id="typ" value="{{ old('typ') }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;" placeholder="np. nazwa organizacji">
            @error('typ')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label for="plan" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Plan</label>
            <select name="plan" id="plan" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="">—</option>
                <option value="FREE" {{ old('plan') === 'FREE' ? 'selected' : '' }}>Free</option>
                <option value="FULL" {{ old('plan') === 'FULL' ? 'selected' : '' }}>Full</option>
            </select>
            @error('plan')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" style="padding: 0.5rem 1.25rem; background: #1e40af; color: #fff; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">Zapisz</button>
    </form>
@endsection
