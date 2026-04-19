@extends('layouts.app')

@section('title', __('overview.page_title'))

@section('content')
    <div class="przeglad-page">
        @if($wyborKorzenia)
            <div class="max-w-lg mx-auto px-4 py-6">
                <h1 class="text-xl font-semibold text-gray-900 mb-2">{{ __('overview.pick_root_title') }}</h1>
                <p class="text-sm text-gray-600 mb-4">{{ __('overview.pick_root_intro') }}</p>
                <p class="text-sm text-gray-500 mb-4">{{ __('overview.pick_root_only_managers') }}</p>
                <form method="get" action="{{ \App\Support\AppUrl::route('przeglad') }}" class="space-y-4">
                    <div>
                        <label for="przeglad-korzen" class="block text-sm font-medium text-gray-700 mb-1">{{ __('overview.pick_root_label') }}</label>
                        <select name="korzen" id="przeglad-korzen" required
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500">
                            <option value="">{{ __('overview.pick_root_placeholder') }}</option>
                            @foreach($pracownicyDoWyboru as $p)
                                <option value="{{ $p->id }}">{{ $p->imie }} {{ $p->nazwisko }} — {{ $p->stanowisko }}{{ $p->grupa ? __('overview.group_suffix') : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center rounded-md bg-violet-700 px-4 py-2 text-sm font-medium text-white hover:bg-violet-800">
                        {{ __('overview.pick_root_submit') }}
                    </button>
                </form>
            </div>
        @else
            @if(($przegladPustyPowod ?? null) === 'brak_pracownikow')
                <div class="schemat-wrapper flex justify-center items-start min-h-[40vh]">
                    <p class="schemat-empty">{{ __('overview.empty') }}</p>
                </div>
            @elseif(($przegladPustyPowod ?? null) === 'brak_szefow')
                <div class="schemat-wrapper flex justify-center items-start min-h-[40vh]">
                    <p class="schemat-empty max-w-md text-center">{{ __('overview.no_managers') }}</p>
                </div>
            @else
                <div class="px-4 pt-4 pb-2 max-w-4xl mx-auto flex flex-wrap items-center justify-between gap-2">
                    <p class="text-sm text-gray-600">{{ __('overview.chart_hint') }}</p>
                    <a href="{{ \App\Support\AppUrl::route('przeglad') }}" class="text-sm font-medium text-violet-700 hover:text-violet-900">{{ __('overview.change_root') }}</a>
                </div>
                <div class="schemat-wrapper">
                    <div id="przeglad-zoom-container" class="przeglad-zoom-container">
                        <div class="schemat-root flex justify-center w-full">
                            @include('przeglad._org-node', ['pracownik' => $korzen, 'isChild' => false, 'czyMatrix' => false, 'przegladPoziom' => 0])
                        </div>
                    </div>
                </div>
                <div class="przeglad-zoom-buttons">
                    <button type="button" class="przeglad-zoom-btn przeglad-zoom-in" title="{{ __('overview.zoom_in') }}" aria-label="{{ __('overview.zoom_in') }}">+</button>
                    <button type="button" class="przeglad-zoom-btn przeglad-zoom-out" title="{{ __('overview.zoom_out') }}" aria-label="{{ __('overview.zoom_out') }}">−</button>
                </div>
            @endif
        @endif
    </div>
@endsection
