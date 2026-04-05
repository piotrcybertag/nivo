@extends('landing.layout')

@php
    /** @var string $pageKey */
    $p = 'landing.funkcja_pages.'.$pageKey;
@endphp

@section('title', __($p.'.title_suffix'))
@section('meta_description', __($p.'.meta'))

@section('content')
<section class="relative overflow-hidden bg-gradient-to-b from-slate-100 via-violet-50/50 to-white border-b border-violet-100/90">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-14 lg:py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-xs font-bold tracking-widest text-violet-700 uppercase mb-3">{{ __($p.'.hero_kicker') }}</p>
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">{{ __($p.'.hero_title') }}</h1>
                <p class="mt-4 text-lg text-slate-700 font-medium leading-relaxed">{{ __($p.'.hero_lead') }}</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ \App\Support\LandingAlternateUrls::homeUrl() }}" class="inline-flex items-center px-5 py-2.5 rounded-lg border-2 border-slate-700 text-slate-800 font-semibold text-sm hover:bg-slate-100 transition">
                        {{ __($p.'.cta_home') }}
                    </a>
                    @if(!session('uzytkownik_id'))
                        <a href="{{ \App\Support\LandingAlternateUrls::rejestracjaUrl('free') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-violet-600 text-white font-semibold text-sm hover:bg-violet-700 transition shadow-md shadow-violet-600/25">
                            {{ __('landing.funkcja_pages.cta_try') }}
                        </a>
                    @else
                        <a href="{{ \App\Support\LandingAlternateUrls::appSchematUrl() }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-violet-600 text-white font-semibold text-sm hover:bg-violet-700 transition shadow-md shadow-violet-600/25">
                            {{ __('landing.nav.back_app') }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="flex justify-center lg:justify-end">
                <div class="w-full max-w-[260px] rounded-2xl bg-white/90 p-8 shadow-xl ring-1 ring-violet-200/70 backdrop-blur-sm">
                    @include('landing.partials.mega-svg-'.$pageKey, ['large' => true])
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-3xl mx-auto px-4 sm:px-6 py-14 lg:py-16">
    <div class="space-y-10">
        @foreach (__($p.'.sections') as $section)
            <div>
                <h2 class="text-xl font-bold text-slate-900">{{ $section['h'] }}</h2>
                <p class="mt-3 text-slate-700 leading-relaxed text-[15px]">{{ $section['p'] }}</p>
            </div>
        @endforeach
    </div>
</section>
@endsection
