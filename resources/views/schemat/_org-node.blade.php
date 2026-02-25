<div class="org-node {{ isset($czyMatrix) && $czyMatrix ? 'org-node--matrix' : '' }}">
    @php $urlSchemat = route('schemat', ['pracownik' => $pracownik->id]); @endphp
    @php
        $liczbaPodwladnych = isset($pracownik->total_podwladni_count)
            ? $pracownik->total_podwladni_count
            : (($pracownik->relationLoaded('podwladni') ? $pracownik->podwladni->count() : ($pracownik->podwladni_count ?? 0))
                + ($pracownik->relationLoaded('podwladniMatrix') ? $pracownik->podwladniMatrix->count() : ($pracownik->podwladni_matrix_count ?? 0)));
    @endphp
    <a href="{{ $urlSchemat }}" class="schemat-box org-box org-box--clickable {{ isset($czyMatrix) && $czyMatrix ? 'org-box--matrix' : '' }}">
        <div class="schemat-name">{{ $pracownik->imie }} {{ $pracownik->nazwisko }}{{ isset($czyMatrix) && $czyMatrix ? ' (M)' : '' }}</div>
        <div class="schemat-stanowisko">{{ $pracownik->stanowisko }}</div>
        @if($liczbaPodwladnych > 0)
            <div class="schemat-podwladni-count">1+({{ $liczbaPodwladnych }})</div>
        @endif
    </a>
    @php
        $podwladniLinia = $pracownik->relationLoaded('podwladni') ? $pracownik->podwladni : collect();
        $podwladniMat = $pracownik->relationLoaded('podwladniMatrix') ? $pracownik->podwladniMatrix : collect();
        $wszyscyPodwladni = $podwladniLinia->concat($podwladniMat);
        $maPodwladnychDoRysowania = !isset($isChild) && $wszyscyPodwladni->isNotEmpty();
    @endphp
    @if($maPodwladnychDoRysowania)
        @php
            $n = $wszyscyPodwladni->count();
            $cols = $n > 4 ? 4 : $n;
            $multiRow = $n > 4;
        @endphp
        <div class="org-connector-wrap">
            <svg class="org-lines-svg" aria-hidden="true"></svg>
            <div class="org-children">
                <div class="org-branch {{ $multiRow ? 'org-branch--multi-row' : '' }}" style="--child-count: {{ $cols }}; grid-template-columns: repeat({{ $cols }}, 1fr);">
                    <div class="org-branch-children">
                        @foreach($pracownik->podwladni as $pod)
                            @include('schemat._org-node', ['pracownik' => $pod, 'isChild' => true, 'czyMatrix' => false])
                        @endforeach
                        @foreach($pracownik->podwladniMatrix as $pod)
                            @include('schemat._org-node', ['pracownik' => $pod, 'isChild' => true, 'czyMatrix' => true])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
