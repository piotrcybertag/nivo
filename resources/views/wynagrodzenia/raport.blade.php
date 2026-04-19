@extends('layouts.app')

@section('title', __('app.wynagrodzenia_raport.page_title'))

@section('content')
    <style>
        .wyn-raport-wrap { max-width: min(100%, 100ch); }
        .wyn-raport-back { display: inline-block; margin-bottom: 1rem; color: #2563eb; text-decoration: none; font-weight: 500; font-size: 0.9375rem; }
        .wyn-raport-back:hover { text-decoration: underline; }
        .wyn-raport-filter { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 0.75rem 1rem; margin-bottom: 1.25rem; padding: 1rem; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 0.5rem; }
        .wyn-raport-filter label { display: block; font-weight: 600; font-size: 0.875rem; color: #374151; margin-bottom: 0.35rem; }
        .wyn-raport-filter select { min-width: 16rem; padding: 0.45rem 0.65rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem; }
        .wyn-raport-filter button { padding: 0.45rem 1rem; background: #1e40af; color: #fff; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.9375rem; cursor: pointer; }
        .wyn-raport-filter button:hover { background: #1d4ed8; }
        .wyn-raport-filter a.secondary { display: inline-flex; align-items: center; padding: 0.45rem 1rem; color: #1e40af; border: 1px solid #1e40af; border-radius: 0.375rem; font-weight: 600; font-size: 0.9375rem; text-decoration: none; }
        .wyn-raport-filter a.secondary:hover { background: #eff6ff; }
        .wyn-raport-table { width: 100%; border-collapse: collapse; font-size: 0.9375rem; background: #fff; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden; }
        .wyn-raport-table th, .wyn-raport-table td { padding: 0.55rem 0.65rem; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .wyn-raport-table th { background: #f9fafb; font-weight: 600; color: #374151; }
        .wyn-raport-table tr:last-child td { border-bottom: none; }
        .wyn-raport-table td.num { text-align: right; font-variant-numeric: tabular-nums; }
        .wyn-raport-summary { margin-top: 1.25rem; padding: 1rem 1.25rem; background: #f0fdf4; border: 1px solid #86efac; border-radius: 0.5rem; }
        .wyn-raport-summary dt { font-weight: 600; color: #166534; font-size: 0.875rem; margin-top: 0.5rem; }
        .wyn-raport-summary dt:first-child { margin-top: 0; }
        .wyn-raport-summary dd { margin: 0.2rem 0 0; font-size: 1.125rem; color: #14532d; font-weight: 700; }
        .wyn-raport-empty { color: #6b7280; }
        .wyn-raport-muted { color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem; }
        .wyn-raport-namecell { display: inline-flex; align-items: center; gap: 0.35rem; flex-wrap: wrap; }
        .wyn-raport-legend { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-bottom: 1rem; font-size: 0.8125rem; color: #4b5563; }
        .wyn-raport-legend span { display: inline-flex; align-items: center; gap: 0.35rem; }
    </style>

    <div class="wyn-raport-wrap">
        <a href="{{ $backUrl }}" class="wyn-raport-back">{{ __('app.wynagrodzenia_raport.back') }}</a>

        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin: 0 0 0.5rem;">{{ __('app.wynagrodzenia_raport.heading') }}</h1>
        <p style="margin: 0 0 1rem; color: #4b5563; max-width: 42rem;">{{ __('app.wynagrodzenia_raport.intro') }}</p>

        <form method="get" action="{{ $raportUrl }}" class="wyn-raport-filter">
            <div>
                <label for="filter-szef">{{ __('app.wynagrodzenia_raport.filter_label') }}</label>
                <select name="szef" id="filter-szef">
                    <option value="">{{ __('app.wynagrodzenia_raport.filter_all') }}</option>
                    @foreach ($szefowieDoFiltra as $s)
                        <option value="{{ $s->id }}" @selected((int) ($wybranySzefId ?? 0) === (int) $s->id)>{{ $s->imie }} {{ $s->nazwisko }} — {{ $s->stanowisko }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">{{ __('app.wynagrodzenia_raport.filter_submit') }}</button>
            @if ($wybranySzefId !== null)
                <a href="{{ $raportUrl }}" class="secondary">{{ __('app.wynagrodzenia_raport.filter_reset') }}</a>
            @endif
        </form>
        <p class="wyn-raport-muted" style="margin-top: -0.5rem; margin-bottom: 1rem;">{{ __('app.wynagrodzenia_raport.filter_hint') }}</p>

        @if (! empty($pokazLegendeWidelek ?? false))
            <p class="wyn-raport-muted" style="margin-bottom: 0.5rem;">{{ __('app.wynagrodzenia_raport.band_legend_intro') }}</p>
            <div class="wyn-raport-legend" role="note">
                <span><span class="wyn-raport-band wyn-raport-band--below" aria-hidden="true">↓</span> {{ __('app.wynagrodzenia_raport.band_legend_below') }}</span>
                <span><span class="wyn-raport-band wyn-raport-band--above" aria-hidden="true">↑</span> {{ __('app.wynagrodzenia_raport.band_legend_above') }}</span>
            </div>
        @endif

        @if ($wiersze === [])
            <p class="wyn-raport-empty">{{ __('app.wynagrodzenia_raport.empty') }}</p>
        @else
            <table class="wyn-raport-table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('app.wynagrodzenia_raport.col_name') }}</th>
                        <th scope="col">{{ __('app.wynagrodzenia_raport.col_position') }}</th>
                        <th scope="col" class="num">{{ __('app.wynagrodzenia_raport.col_fte') }}</th>
                        <th scope="col" class="num">{{ __('app.wynagrodzenia_raport.col_salary') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wiersze as $w)
                        @php $p = $w['pracownik']; @endphp
                        <tr>
                            <td>
                                <span class="wyn-raport-namecell">
                                    <a href="{{ \App\Support\AppUrl::route('kartoteki.pracownicy.show', $p) }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">{{ $p->imie_nazwisko }}</a>
                                    @if (($w['band_flag'] ?? null) === 'below' && ! empty($w['band_tooltip']))
                                        <span class="wyn-raport-band wyn-raport-band--below" title="{{ $w['band_tooltip'] }}" aria-label="{{ $w['band_tooltip'] }}">↓</span>
                                    @elseif (($w['band_flag'] ?? null) === 'above' && ! empty($w['band_tooltip']))
                                        <span class="wyn-raport-band wyn-raport-band--above" title="{{ $w['band_tooltip'] }}" aria-label="{{ $w['band_tooltip'] }}">↑</span>
                                    @endif
                                </span>
                            </td>
                            <td>{{ $p->stanowisko }}</td>
                            <td class="num">{{ $w['wymiar'] !== null ? number_format($w['wymiar'], 1, '.', '') : __('app.wynagrodzenia_raport.dash') }}</td>
                            <td class="num">{{ $w['wynagrodzenie'] !== null ? number_format($w['wynagrodzenie'], 2, '.', '') : __('app.wynagrodzenia_raport.dash') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="wyn-raport-summary">
                <dl style="margin: 0;">
                    <dt>{{ __('app.wynagrodzenia_raport.summary_total') }}</dt>
                    <dd>{{ number_format($sumaWynagrodzen, 2, '.', '') }}</dd>
                    <dt>{{ __('app.wynagrodzenia_raport.summary_count_salary') }}</dt>
                    <dd>{{ $licznikZWynagrodzeniem }}</dd>
                    @if ($licznikBezPelnychDanych > 0)
                        <dt>{{ __('app.wynagrodzenia_raport.summary_incomplete') }}</dt>
                        <dd>{{ $licznikBezPelnychDanych }}</dd>
                    @endif
                </dl>
                <p class="wyn-raport-muted">{{ __('app.wynagrodzenia_raport.summary_note') }}</p>
            </div>
        @endif
    </div>
@endsection
