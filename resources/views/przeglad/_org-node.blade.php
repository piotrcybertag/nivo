<div class="org-node {{ isset($czyMatrix) && $czyMatrix ? 'org-node--matrix' : '' }}">
    <div class="schemat-box org-box {{ isset($czyMatrix) && $czyMatrix ? 'org-box--matrix' : '' }} {{ $pracownik->grupa ? 'org-box--grupa' : '' }}">
        <div class="schemat-name">{{ $pracownik->imie }} {{ $pracownik->nazwisko }}{{ isset($czyMatrix) && $czyMatrix ? ' (M)' : '' }}{{ $pracownik->grupa ? ' · Grupa' : '' }}</div>
        <div class="schemat-stanowisko">{{ $pracownik->stanowisko }}</div>
    </div>
    @php
        $podwladniLinia = $pracownik->relationLoaded('podwladni') ? $pracownik->podwladni : collect();
        $podwladniMat = $pracownik->relationLoaded('podwladniMatrix') ? $pracownik->podwladniMatrix : collect();
        $wszyscyPodwladni = $podwladniLinia->concat($podwladniMat);
        $maPodwladnychDoRysowania = $wszyscyPodwladni->isNotEmpty();
    @endphp
    @if($maPodwladnychDoRysowania)
        @php
            $n = $wszyscyPodwladni->count();
            $wszyscyBezPodwladnych = $wszyscyPodwladni->every(function($p) {
                $pl = $p->relationLoaded('podwladni') ? $p->podwladni : collect();
                $pm = $p->relationLoaded('podwladniMatrix') ? $p->podwladniMatrix : collect();
                return $pl->isEmpty() && $pm->isEmpty();
            });
            $ostatniPoziom = $wszyscyBezPodwladnych;
            $cols = $ostatniPoziom ? 1 : ($n > 4 ? 4 : $n);
            $multiRow = !$ostatniPoziom && $n > 4;
        @endphp
        <div class="org-connector-wrap">
            <svg class="org-lines-svg" aria-hidden="true"></svg>
            <div class="org-children">
                <div class="org-branch {{ $multiRow ? 'org-branch--multi-row' : '' }} {{ $ostatniPoziom ? 'org-branch--vertical' : '' }}" style="--child-count: {{ $cols }}; grid-template-columns: repeat({{ $cols }}, 1fr);">
                    <div class="org-branch-children">
                        @foreach($pracownik->podwladni as $pod)
                            @include('przeglad._org-node', ['pracownik' => $pod, 'isChild' => true, 'czyMatrix' => false])
                        @endforeach
                        @foreach($pracownik->podwladniMatrix as $pod)
                            @include('przeglad._org-node', ['pracownik' => $pod, 'isChild' => true, 'czyMatrix' => true])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
