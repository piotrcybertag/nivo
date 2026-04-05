@extends('layouts.app')

@section('title', __('employees.edit_title'))

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.index') }}" style="color: #2563eb; text-decoration: none;">{{ __('employees.back_to_list') }}</a>
    </div>
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1.5rem;">{{ __('employees.edit_title') }}</h1>

    <form action="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.update', $pracownik) }}" method="POST" style="max-width: 28rem;">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 1rem;">
            <label for="imie" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('employees.label_first_name') }}{{ __('employees.required_mark') }}</label>
            <input type="text" name="imie" id="imie" value="{{ old('imie', $pracownik->imie) }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('imie')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="nazwisko" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('employees.label_last_name') }}{{ __('employees.required_mark') }}</label>
            <input type="text" name="nazwisko" id="nazwisko" value="{{ old('nazwisko', $pracownik->nazwisko) }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('nazwisko')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="stanowisko" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('employees.label_position') }}{{ __('employees.required_mark') }}</label>
            <input type="text" name="stanowisko" id="stanowisko" value="{{ old('stanowisko', $pracownik->stanowisko) }}" required
                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            @error('stanowisko')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="hidden" name="grupa" value="0">
                <input type="checkbox" name="grupa" id="grupa" value="1" {{ old('grupa', $pracownik->grupa) ? 'checked' : '' }}
                       style="width: 1.125rem; height: 1.125rem;">
                <span style="font-weight: 500;">{{ __('employees.label_group') }}</span>
            </label>
            <p style="margin: 0.25rem 0 0; font-size: 0.8125rem; color: #6b7280;">{{ __('employees.group_help_edit') }}</p>
            @error('grupa')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="id_szefa" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('employees.label_manager_line') }}</label>
            <select name="id_szefa" id="id_szefa" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="">{{ __('employees.none') }}</option>
                @foreach($pracownicy as $p)
                    <option value="{{ $p->id }}" {{ old('id_szefa', $pracownik->id_szefa) == $p->id ? 'selected' : '' }}>{{ $p->imie_nazwisko }} ({{ $p->stanowisko }})</option>
                @endforeach
            </select>
            @error('id_szefa')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label for="szef_matrix" style="display: block; font-weight: 500; margin-bottom: 0.25rem;">{{ __('employees.label_manager_matrix') }}</label>
            <select name="szef_matrix" id="szef_matrix" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="">{{ __('employees.none') }}</option>
                @foreach($pracownicy as $p)
                    <option value="{{ $p->id }}" {{ old('szef_matrix', $pracownik->szef_matrix) == $p->id ? 'selected' : '' }}>{{ $p->imie_nazwisko }} ({{ $p->stanowisko }})</option>
                @endforeach
            </select>
            @error('szef_matrix')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" style="padding: 0.5rem 1.25rem; background: #1e40af; color: #fff; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">{{ __('employees.save_changes') }}</button>
    </form>
@endsection
