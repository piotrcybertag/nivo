@extends('layouts.app')

@section('title', 'Schemat organizacyjny')

@section('content')
    <div class="schemat-strona" data-page="schemat">
        <aside class="schemat-panel-boczny">
            <form action="{{ route('schemat') }}" method="GET" class="schemat-szukaj-form" id="schemat-szukaj-form">
                @if(request('pracownik'))
                    <input type="hidden" name="pracownik" value="{{ request('pracownik') }}">
                @endif
                <label for="szukaj" class="schemat-szukaj-label">Szukaj pracownika (nazwisko lub imię)</label>
                <input type="text" name="szukaj" id="szukaj" value="{{ $szukaj }}" placeholder="np. Kowal" class="schemat-szukaj-input" autocomplete="off">
                <button type="submit" class="schemat-szukaj-btn">Szukaj</button>
            </form>
            @if($wynikiWyszukiwania->isNotEmpty())
                <ul class="schemat-lista-wynikow">
                    @foreach($wynikiWyszukiwania as $p)
                        <li>
                            <a href="{{ route('schemat', ['pracownik' => $p->id]) }}" class="schemat-wynik-link">{{ $p->nazwisko }} {{ $p->imie }} <span class="schemat-wynik-stanowisko">({{ $p->stanowisko }})</span></a>
                        </li>
                    @endforeach
                </ul>
            @elseif($szukaj !== '')
                <p class="schemat-brak-wynikow">Brak pracowników pasujących do „{{ $szukaj }}”.</p>
            @endif
        </aside>
        <div class="schemat-wrapper">
        @if($korzenie->isEmpty())
            <p class="schemat-empty">Brak pracowników w bazie. Dodaj pracowników w kartotece Pracownicy — pracownik bez szefa będzie początkiem struktury.</p>
        @else
            <div class="schemat-root schemat-root--z-nad-szefem">
                @if(count($nadSzefowie) > 0)
                    <div class="org-connector-wrap-nad-szefem">
                        <svg class="org-lines-svg" aria-hidden="true"></svg>
                        <div class="org-nad-szefem-row">
                            @foreach($nadSzefowie as $s)
                                <a href="{{ route('schemat', ['pracownik' => $s['pracownik']->id]) }}" class="schemat-box org-box org-box-nad-szefem org-box--clickable {{ $s['typ'] === 'matrix' ? 'org-box--matrix' : '' }} {{ $s['pracownik']->grupa ? 'org-box--grupa' : '' }}">
                                    @if(($s['liczba_pracownikow'] ?? 0) > 0)
                                        <div class="schemat-pracownicy-total">{{ $s['liczba_pracownikow'] }} pracowników</div>
                                    @endif
                                    <div class="schemat-name">{{ $s['pracownik']->imie }} {{ $s['pracownik']->nazwisko }}{{ $s['typ'] === 'matrix' ? ' (M)' : '' }}{{ $s['pracownik']->grupa ? ' · Grupa' : '' }}</div>
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
                                <div class="schemat-pracownicy-total">{{ $totalPracownikow }} pracowników</div>
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
