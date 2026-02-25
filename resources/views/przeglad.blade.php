@extends('layouts.app')

@section('title', 'Przegląd struktury')

@section('content')
    <div class="przeglad-page">
        <div class="schemat-wrapper">
            <div id="przeglad-zoom-container" class="przeglad-zoom-container">
                @if($korzenie->isEmpty())
                    <p class="schemat-empty">Brak pracowników w bazie.</p>
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
            <button type="button" class="przeglad-zoom-btn przeglad-zoom-in" title="Powiększ" aria-label="Powiększ">+</button>
            <button type="button" class="przeglad-zoom-btn przeglad-zoom-out" title="Pomniejsz" aria-label="Pomniejsz">−</button>
        </div>
    </div>
@endsection
