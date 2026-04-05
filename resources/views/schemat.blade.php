@extends('layouts.app')

@php
    use App\Support\AppUrl;
@endphp

@section('title', __('app.schemat.page_title'))

@section('content')
    <div class="schemat-strona" data-page="schemat">
        <aside class="schemat-panel-boczny">
            <form action="{{ AppUrl::route('schemat') }}" method="GET" class="schemat-szukaj-form" id="schemat-szukaj-form">
                @if(request('pracownik'))
                    <input type="hidden" name="pracownik" value="{{ request('pracownik') }}">
                @endif
                <label for="szukaj" class="schemat-szukaj-label">{{ __('app.schemat.search_label') }}</label>
                <input type="text" name="szukaj" id="szukaj" value="{{ $szukaj }}" placeholder="{{ __('app.schemat.search_placeholder') }}" class="schemat-szukaj-input" autocomplete="off">
                <button type="submit" class="schemat-szukaj-btn">{{ __('app.schemat.search_button') }}</button>
            </form>
            @if($wynikiWyszukiwania->isNotEmpty())
                <ul class="schemat-lista-wynikow">
                    @foreach($wynikiWyszukiwania as $p)
                        <li>
                            <a href="{{ AppUrl::route('schemat', ['pracownik' => $p->id]) }}" class="schemat-wynik-link">{{ $p->nazwisko }} {{ $p->imie }} <span class="schemat-wynik-stanowisko">({{ $p->stanowisko }})</span></a>
                        </li>
                    @endforeach
                </ul>
            @elseif($szukaj !== '')
                <p class="schemat-brak-wynikow">{{ __('app.schemat.no_results', ['term' => $szukaj]) }}</p>
            @endif
        </aside>
        <div class="schemat-wrapper">
        @if($korzenie->isEmpty())
            <p class="schemat-empty">{{ __('app.schemat.empty_org') }}</p>
        @else
            <div class="schemat-root schemat-root--z-nad-szefem">
                @if(count($nadSzefowie) > 0)
                    <div class="org-connector-wrap-nad-szefem">
                        <svg class="org-lines-svg" aria-hidden="true"></svg>
                        <div class="org-nad-szefem-row">
                            @foreach($nadSzefowie as $s)
                                <a href="{{ AppUrl::route('schemat', ['pracownik' => $s['pracownik']->id]) }}" class="schemat-box org-box org-box-nad-szefem org-box--clickable {{ $s['typ'] === 'matrix' ? 'org-box--matrix' : '' }} {{ $s['pracownik']->grupa ? 'org-box--grupa' : '' }}">
                                    @if(($s['liczba_pracownikow'] ?? 0) > 0)
                                        <div class="schemat-pracownicy-total">{{ __('app.schemat.headcount', ['count' => $s['liczba_pracownikow']]) }}</div>
                                    @endif
                                    <div class="schemat-name">{{ $s['pracownik']->imie }} {{ $s['pracownik']->nazwisko }}{{ $s['typ'] === 'matrix' ? __('app.schemat.matrix_suffix') : '' }}{{ $s['pracownik']->grupa ? __('app.schemat.group_suffix') : '' }}</div>
                                    <div class="schemat-stanowisko">{{ $s['pracownik']->stanowisko }}</div>
                                </a>
                            @endforeach
                        </div>
                        <div class="schemat-root schemat-root-pod-nad-szefem">
                            @foreach($korzenie as $p)
                                @include('schemat._org-node', ['pracownik' => $p])
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="org-nad-szefem-row">
                        <div class="schemat-box org-box org-box-nad-szefem">
                            @if($totalPracownikow > 0)
                                <div class="schemat-pracownicy-total">{{ __('app.schemat.headcount', ['count' => $totalPracownikow]) }}</div>
                            @endif
                            <div class="schemat-name">{{ session('uzytkownik_typ') ?: '—' }}</div>
                        </div>
                    </div>
                    <div class="schemat-root schemat-root-pod-nad-szefem">
                        @foreach($korzenie as $p)
                            @include('schemat._org-node', ['pracownik' => $p])
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
        </div>
    </div>
    <script>
    (function() {
        var form = document.getElementById('schemat-szukaj-form');
        var input = document.getElementById('szukaj');
        if (!form || !input) return;
        var debounceTimer;
        input.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() { form.submit(); }, 350);
        });
    })();
    </script>
@endsection
