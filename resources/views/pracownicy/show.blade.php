@extends('layouts.app')

@section('title', __('employees.show_heading_prefix').' '.$pracownik->imie_nazwisko)

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.index') }}" style="color: #2563eb; text-decoration: none;">{{ __('employees.back_to_list') }}</a>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin: 0;">{{ $pracownik->imie_nazwisko }}</h1>
        <div>
            <a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.edit', $pracownik) }}" style="display: inline-block; padding: 0.5rem 1rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">{{ __('employees.edit') }}</a>
        </div>
    </div>

    <div style="background: #fff; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); max-width: 28rem;">
        <dl style="margin: 0; display: grid; gap: 0.75rem;">
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">{{ __('employees.field_id') }}</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $pracownik->id }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">{{ __('employees.label_first_name') }}</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $pracownik->imie }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">{{ __('employees.label_last_name') }}</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $pracownik->nazwisko }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">{{ __('employees.label_position') }}</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $pracownik->stanowisko }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">{{ __('employees.label_group') }}</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $pracownik->grupa ? __('employees.yes') : __('employees.no') }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">{{ __('employees.field_manager_id') }}</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">{{ $pracownik->id_szefa ?? __('employees.dash') }}</dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">{{ __('employees.field_manager_line') }}</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">
                    @if($pracownik->szef)
                        <a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.show', $pracownik->szef) }}" style="color: #2563eb; text-decoration: none;">{{ $pracownik->szef->imie_nazwisko }}</a>
                    @else
                        {{ __('employees.dash') }}
                    @endif
                </dd>
            </div>
            <div>
                <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">{{ __('employees.field_manager_matrix') }}</dt>
                <dd style="margin: 0.25rem 0 0; font-size: 1rem;">
                    @if($pracownik->szefMatrix)
                        <a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.show', $pracownik->szefMatrix) }}" style="color: #2563eb; text-decoration: none;">{{ $pracownik->szefMatrix->imie_nazwisko }}</a>
                    @else
                        {{ __('employees.dash') }}
                    @endif
                </dd>
            </div>
            @if($pracownik->podwladni->isNotEmpty())
                <div>
                    <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">{{ __('employees.field_reports_line') }}</dt>
                    <dd style="margin: 0.25rem 0 0;">
                        <ul style="margin: 0; padding-left: 1.25rem;">
                            @foreach($pracownik->podwladni as $pod)
                                <li><a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.show', $pod) }}" style="color: #2563eb; text-decoration: none;">{{ $pod->imie_nazwisko }}</a></li>
                            @endforeach
                        </ul>
                    </dd>
                </div>
            @endif
            @if($pracownik->podwladniMatrix->isNotEmpty())
                <div>
                    <dt style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">{{ __('employees.field_reports_matrix') }}</dt>
                    <dd style="margin: 0.25rem 0 0;">
                        <ul style="margin: 0; padding-left: 1.25rem;">
                            @foreach($pracownik->podwladniMatrix as $pod)
                                <li><a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.show', $pod) }}" style="color: #2563eb; text-decoration: none;">{{ $pod->imie_nazwisko }}</a></li>
                            @endforeach
                        </ul>
                    </dd>
                </div>
            @endif
        </dl>
    </div>
@endsection
