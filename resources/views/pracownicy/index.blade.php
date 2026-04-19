@extends('layouts.app')

@section('title', __('employees.page_title'))

@section('content')
    @php
        $indexUrl = \App\Support\AppUrl::route('kartoteki.pracownicy.index');
        $sortLink = function (string $col) use ($indexUrl, $q, $sort, $dir) {
            $nextDir = 'asc';
            if ($sort === $col) {
                $nextDir = $dir === 'asc' ? 'desc' : 'asc';
            }
            $qs = array_filter(['q' => $q, 'sort' => $col, 'dir' => $nextDir], fn ($v) => $v !== null && $v !== '');

            return $indexUrl.(str_contains($indexUrl, '?') ? '&' : '?').http_build_query($qs);
        };
    @endphp
    <style>
        .pracownik-akcja-link:hover, .pracownik-akcja-btn:hover { opacity: 0.8; background: rgba(0,0,0,0.06); }
        .pracownicy-sort-th a { color: inherit; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem; cursor: pointer; border-radius: 0.25rem; padding: 0.125rem 0; }
        .pracownicy-sort-th a:hover { color: #1e40af; text-decoration: underline; }
        .pracownicy-sort-th--active a { color: #1e40af; font-weight: 700; }
    </style>
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin: 0;">{{ __('employees.heading') }}</h1>
        @if($canAddPracownik)
            <a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.create') }}" style="display: inline-block; padding: 0.5rem 1rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">{{ __('employees.add') }}</a>
        @else
            <span style="font-size: 0.875rem; color: #6b7280;">{{ __('employees.free_limit', ['limit' => $limitFree]) }} <a href="{{ \App\Support\AppUrl::route('ustawienia') }}" style="color: #1e40af;">{{ __('employees.upgrade_in_settings') }}</a></span>
        @endif
    </div>

    <form method="get" action="{{ $indexUrl }}" style="margin-bottom: 1rem; display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem 1rem;">
        <input type="hidden" name="sort" value="{{ $sort }}">
        <input type="hidden" name="dir" value="{{ $dir }}">
        <label for="pracownicy-q" style="font-weight: 500; color: #374151;">{{ __('employees.search_label') }}</label>
        <input id="pracownicy-q" type="search" name="q" value="{{ $q }}" placeholder="{{ __('employees.search_placeholder') }}" autocomplete="off" style="flex: 1; min-width: 12rem; max-width: 28rem; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem;">
        <button type="submit" style="padding: 0.5rem 1rem; background: #374151; color: #fff; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">{{ __('employees.search_button') }}</button>
        @if($q !== '')
            <a href="{{ $indexUrl }}?{{ http_build_query(array_filter(['sort' => $sort, 'dir' => $dir], fn ($v) => $v !== null && $v !== '')) }}" style="color: #2563eb; font-size: 0.875rem;">{{ __('employees.search_clear') }}</a>
        @endif
    </form>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 0.5rem;">
            <thead>
                <tr style="background: #f3f4f6; border-bottom: 2px solid #e5e7eb;">
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">{{ __('employees.col_id') }}</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">{{ __('employees.col_first_name') }}</th>
                    <th class="pracownicy-sort-th {{ $sort === 'nazwisko' ? 'pracownicy-sort-th--active' : '' }}" style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;" @if($sort === 'nazwisko') aria-sort="{{ $dir === 'asc' ? 'ascending' : 'descending' }}" @endif>
                        <a href="{{ $sortLink('nazwisko') }}" title="{{ __('employees.sort_click') }}">{{ __('employees.col_last_name') }}@if($sort === 'nazwisko') <span aria-hidden="true">{{ $dir === 'asc' ? '↑' : '↓' }}</span>@endif</a>
                    </th>
                    <th class="pracownicy-sort-th {{ $sort === 'stanowisko' ? 'pracownicy-sort-th--active' : '' }}" style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;" @if($sort === 'stanowisko') aria-sort="{{ $dir === 'asc' ? 'ascending' : 'descending' }}" @endif>
                        <a href="{{ $sortLink('stanowisko') }}" title="{{ __('employees.sort_click') }}">{{ __('employees.col_position') }}@if($sort === 'stanowisko') <span aria-hidden="true">{{ $dir === 'asc' ? '↑' : '↓' }}</span>@endif</a>
                    </th>
                    <th class="pracownicy-sort-th {{ $sort === 'grupa' ? 'pracownicy-sort-th--active' : '' }}" style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;" @if($sort === 'grupa') aria-sort="{{ $dir === 'asc' ? 'ascending' : 'descending' }}" @endif>
                        <a href="{{ $sortLink('grupa') }}" title="{{ __('employees.sort_click') }}">{{ __('employees.col_group') }}@if($sort === 'grupa') <span aria-hidden="true">{{ $dir === 'asc' ? '↑' : '↓' }}</span>@endif</a>
                    </th>
                    <th class="pracownicy-sort-th {{ $sort === 'szef' ? 'pracownicy-sort-th--active' : '' }}" style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;" @if($sort === 'szef') aria-sort="{{ $dir === 'asc' ? 'ascending' : 'descending' }}" @endif>
                        <a href="{{ $sortLink('szef') }}" title="{{ __('employees.sort_click') }}">{{ __('employees.col_manager') }}@if($sort === 'szef') <span aria-hidden="true">{{ $dir === 'asc' ? '↑' : '↓' }}</span>@endif</a>
                    </th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">{{ __('employees.col_matrix_manager') }}</th>
                    <th style="text-align: right; padding: 0.75rem 1rem; font-weight: 600;">{{ __('employees.col_actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pracownicy as $p)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 0.75rem 1rem;">{{ $p->id }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->imie }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->nazwisko }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->stanowisko }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->grupa ? __('employees.yes') : __('employees.no') }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->szef ? $p->szef->imie_nazwisko : __('employees.dash') }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $p->szefMatrix ? $p->szefMatrix->imie_nazwisko : __('employees.dash') }}</td>
                        <td style="padding: 0.75rem 1rem; text-align: right; white-space: nowrap;">
                            <a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.show', $p) }}" title="{{ __('employees.title_show') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; color: #2563eb; text-decoration: none; margin-right: 0.25rem; border-radius: 0.25rem;" class="pracownik-akcja-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.edit', $p) }}" title="{{ __('employees.title_edit') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; color: #2563eb; text-decoration: none; margin-right: 0.25rem; border-radius: 0.25rem;" class="pracownik-akcja-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.destroy', $p) }}" method="POST" style="display: inline;" onsubmit="return confirm({{ json_encode(__('employees.confirm_delete')) }});">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="{{ __('employees.title_delete') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: none; border: none; color: #dc2626; cursor: pointer; padding: 0; border-radius: 0.25rem;" class="pracownik-akcja-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="padding: 2rem; text-align: center; color: #6b7280;">
                            @if($q !== '')
                                {{ __('employees.search_empty') }}
                            @else
                                {{ __('employees.empty') }} @if($canAddPracownik)<a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.create') }}" style="color: #2563eb;">{{ __('employees.add_first') }}</a>@else {{ __('employees.empty_free_plan') }} @endif
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pracownicy->hasPages())
        <div style="margin-top: 1.5rem;">{{ $pracownicy->links() }}</div>
    @endif
@endsection
