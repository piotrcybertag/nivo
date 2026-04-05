@extends('layouts.app')

@section('title', __('overview.page_title'))

@section('content')
    <div class="przeglad-page">
        <div class="schemat-wrapper">
            <div id="przeglad-zoom-container" class="przeglad-zoom-container">
                @if($korzenie->isEmpty())
                    <p class="schemat-empty">{{ __('overview.empty') }}</p>
                @else
                    <div class="schemat-root">
                        @foreach($korzenie as $p)
                            @include('przeglad._org-node', ['pracownik' => $p, 'isChild' => false, 'czyMatrix' => false])
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="przeglad-zoom-buttons">
            <button type="button" class="przeglad-zoom-btn przeglad-zoom-in" title="{{ __('overview.zoom_in') }}" aria-label="{{ __('overview.zoom_in') }}">+</button>
            <button type="button" class="przeglad-zoom-btn przeglad-zoom-out" title="{{ __('overview.zoom_out') }}" aria-label="{{ __('overview.zoom_out') }}">−</button>
        </div>
    </div>
@endsection
