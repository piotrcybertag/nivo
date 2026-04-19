@extends('layouts.app')

@php
    use App\Support\AppUrl;
@endphp

@section('title', __('app.stanowiska.siatka_page_title'))

@section('content')
    <style>
        .siatka-wrap { max-width: min(100%, 110ch); }
        .siatka-back {
            display: inline-block; margin-bottom: 1rem; color: #2563eb; text-decoration: none; font-weight: 500; font-size: 0.9375rem;
        }
        .siatka-back:hover { text-decoration: underline; }
        .siatka-flash { padding: 0.65rem 1rem; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.9375rem; }
        .siatka-flash--ok { background: #ecfdf5; color: #047857; border: 1px solid #6ee7b7; }
        .siatka-flash--err { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .siatka-table { width: 100%; border-collapse: collapse; font-size: 0.9375rem; background: #fff; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden; }
        .siatka-table th, .siatka-table td { padding: 0.65rem 0.75rem; text-align: left; vertical-align: top; border-bottom: 1px solid #e5e7eb; }
        .siatka-table th { background: #f9fafb; font-weight: 600; color: #374151; }
        .siatka-table tr:last-child td { border-bottom: none; }
        .siatka-stanowiska { margin: 0; padding: 0; list-style: none; }
        .siatka-stanowiska li { padding: 0.15rem 0; line-height: 1.35; }
        .siatka-input {
            width: 100%; max-width: 11rem; padding: 0.4rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem; box-sizing: border-box;
        }
        .siatka-btn {
            display: inline-flex; align-items: center; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.9375rem; cursor: pointer; border: none;
        }
        .siatka-btn--primary { background: #1e40af; color: #fff; }
        .siatka-btn--primary:hover { background: #1d4ed8; }
        .siatka-empty { color: #6b7280; }
        .siatka-submit-row { margin-top: 1rem; }
    </style>

    <div class="siatka-wrap">
        <a href="{{ $backUrl }}" class="siatka-back">{{ __('app.stanowiska.siatka_back') }}</a>

        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin: 0 0 0.5rem;">{{ __('app.stanowiska.siatka_heading') }}</h1>
        <p style="margin: 0 0 1rem; color: #4b5563; max-width: 42rem;">{{ __('app.stanowiska.siatka_intro') }}</p>

        @if (session('success'))
            <div class="siatka-flash siatka-flash--ok" role="status">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="siatka-flash siatka-flash--err" role="alert">{{ session('error') }}</div>
        @endif

        @if ($grupy === [])
            <p class="siatka-empty">{{ __('app.stanowiska.siatka_empty') }}</p>
        @else
            <form method="post" action="{{ AppUrl::route('stanowiska.siatka-wynagrodzen.save') }}">
                @csrf
                <table class="siatka-table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('app.stanowiska.siatka_col_group') }}</th>
                            <th scope="col">{{ __('app.stanowiska.siatka_col_positions') }}</th>
                            <th scope="col">{{ __('app.stanowiska.siatka_col_from') }}</th>
                            <th scope="col">{{ __('app.stanowiska.siatka_col_to') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grupy as $g)
                            @php
                                $rekord = $g['rekord'];
                                $defOd = $rekord !== null && $rekord->wynagrodzenie_od !== null ? (string) $rekord->wynagrodzenie_od : '';
                                $defDo = $rekord !== null && $rekord->wynagrodzenie_do !== null ? (string) $rekord->wynagrodzenie_do : '';
                                $i = $loop->index;
                            @endphp
                            <tr>
                                <td>{{ $g['numer'] }}</td>
                                <td>
                                    <ul class="siatka-stanowiska">
                                        @foreach ($g['stanowiska'] as $nazwa)
                                            <li>{{ $nazwa }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <input type="hidden" name="grupy[{{ $i }}][indeks_grupy]" value="{{ $g['indeks'] }}">
                                    <input type="number" class="siatka-input" name="grupy[{{ $i }}][wynagrodzenie_od]" id="siatka-od-{{ $i }}" step="0.01" min="0"
                                        value="{{ old('grupy.'.$i.'.wynagrodzenie_od', $defOd) }}" placeholder="—">
                                </td>
                                <td>
                                    <input type="number" class="siatka-input" name="grupy[{{ $i }}][wynagrodzenie_do]" id="siatka-do-{{ $i }}" step="0.01" min="0"
                                        value="{{ old('grupy.'.$i.'.wynagrodzenie_do', $defDo) }}" placeholder="—">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="siatka-submit-row">
                    <button type="submit" class="siatka-btn siatka-btn--primary">{{ __('app.stanowiska.siatka_save') }}</button>
                </div>
            </form>
        @endif
    </div>
@endsection
