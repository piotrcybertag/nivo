@php
    /** @var int $przegladPoziom 0 = wybrany szef, 1 = bezpośredni podwładni, 2 = tylko karty (bez dzieci) */
    $poziom = $przegladPoziom;
@endphp
<div class="org-node {{ isset($czyMatrix) && $czyMatrix ? 'org-node--matrix' : '' }}">
    <div class="schemat-box org-box {{ isset($czyMatrix) && $czyMatrix ? 'org-box--matrix' : '' }} {{ $pracownik->grupa ? 'org-box--grupa' : '' }}">
        <div class="schemat-name">{{ $pracownik->imie }} {{ $pracownik->nazwisko }}{{ isset($czyMatrix) && $czyMatrix ? __('overview.matrix_suffix') : '' }}{{ $pracownik->grupa ? __('overview.group_suffix') : '' }}</div>
        <div class="schemat-stanowisko">{{ $pracownik->stanowisko }}</div>
    </div>
    @php
        $podwladniLinia = $pracownik->relationLoaded('podwladni') ? $pracownik->podwladni : collect();
        $podwladniMat = $pracownik->relationLoaded('podwladniMatrix') ? $pracownik->podwladniMatrix : collect();
        $wszyscyPodwladni = $podwladniLinia->concat($podwladniMat);
        $maPodwladnychDoRysowania = $wszyscyPodwladni->isNotEmpty() && $poziom < 2;
    @endphp
    @if($maPodwladnychDoRysowania)
        @if($poziom === 0)
            @php
                $n = $wszyscyPodwladni->count();
            @endphp
            <div class="org-connector-wrap">
                <svg class="org-lines-svg" aria-hidden="true"></svg>
                <div class="org-children">
                    <div class="org-branch" style="--child-count: {{ $n }}; grid-template-columns: repeat({{ $n }}, 1fr);">
                        <div class="org-branch-children">
                            @foreach($pracownik->podwladni as $pod)
                                @include('przeglad._org-node', ['pracownik' => $pod, 'isChild' => true, 'czyMatrix' => false, 'przegladPoziom' => 1])
                            @endforeach
                            @foreach($pracownik->podwladniMatrix as $pod)
                                @include('przeglad._org-node', ['pracownik' => $pod, 'isChild' => true, 'czyMatrix' => true, 'przegladPoziom' => 1])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Poziom 1: podwładni w kolumnie pod swoim szefem --}}
            <div class="org-connector-wrap">
                <svg class="org-lines-svg" aria-hidden="true"></svg>
                <div class="org-children">
                    <div class="org-branch org-branch--vertical" style="--child-count: 1; grid-template-columns: repeat(1, 1fr);">
                        <div class="org-branch-children">
                            @foreach($pracownik->podwladni as $pod)
                                @include('przeglad._org-node', ['pracownik' => $pod, 'isChild' => true, 'czyMatrix' => false, 'przegladPoziom' => 2])
                            @endforeach
                            @foreach($pracownik->podwladniMatrix as $pod)
                                @include('przeglad._org-node', ['pracownik' => $pod, 'isChild' => true, 'czyMatrix' => true, 'przegladPoziom' => 2])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
