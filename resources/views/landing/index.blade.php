@extends('landing.layout')

@php
    use App\Support\LandingAlternateUrls;
@endphp

@section('title', '')
@section('meta_description', __('landing.meta.description_default'))

@section('content')
<section class="relative overflow-hidden bg-slate-200">
    <div class="w-full px-4 sm:px-6 py-16 lg:py-20">
        <div class="text-center max-w-4xl mx-auto">
            <p class="text-xs font-bold tracking-widest text-violet-700 uppercase mb-4">{{ __('landing.index.hero_kicker') }}</p>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 tracking-tight">
                {{ __('landing.index.hero_title') }}
            </h1>
            <p class="mt-4 text-lg text-slate-800 font-semibold max-w-2xl mx-auto">
                {{ __('landing.index.hero_sub') }}
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                @if(session('uzytkownik_id'))
                    <a href="{{ route('schemat') }}" class="inline-flex items-center justify-center px-8 py-4 bg-violet-600 text-white font-bold rounded-lg hover:bg-violet-700 transition shadow-lg shadow-violet-600/30">
                        {{ __('landing.index.cta_open_schemat') }}
                    </a>
                    <a href="{{ route('cennik') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-slate-700 text-slate-800 font-bold rounded-lg hover:bg-slate-300/80 transition">
                        {{ __('landing.index.cta_pricing') }}
                    </a>
                @else
                    <a href="{{ route('rejestracja', ['plan' => 'free']) }}" class="inline-flex items-center justify-center px-8 py-4 bg-violet-600 text-white font-bold rounded-lg hover:bg-violet-700 transition shadow-lg shadow-violet-600/30">
                        {{ __('landing.index.cta_try_free') }}
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-slate-700 text-slate-800 font-bold rounded-lg hover:bg-slate-300/80 transition">
                        {{ __('landing.index.cta_login') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

<section id="funkcje" class="py-12 lg:py-16 bg-white">
    <div class="w-full px-4 sm:px-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-center text-slate-900 mb-3">{{ __('landing.index.why_title') }}</h2>
        <p class="text-center text-slate-700 font-medium max-w-2xl mx-auto mb-10">{{ __('landing.index.why_intro') }}</p>
        <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <div id="kartoteka" class="text-center scroll-mt-24 rounded-2xl border border-violet-100 bg-gradient-to-b from-white to-violet-50/30 p-6 shadow-sm">
                <div class="flex justify-center mb-4">
                    <div class="inline-flex group">@include('landing.partials.mega-svg-kartoteka')</div>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">{{ __('landing.index.feat_kartoteka_title') }}</h3>
                <p class="text-slate-800 font-medium mb-4">{{ __('landing.index.feat_kartoteka_text') }}</p>
                <a href="{{ LandingAlternateUrls::funkcjaUrl('kartoteka') }}" class="text-sm font-bold text-violet-700 hover:text-violet-900 underline underline-offset-2 decoration-violet-300">{{ __('landing.index.card_read_more') }}</a>
            </div>
            <div id="schemat" class="text-center scroll-mt-24 rounded-2xl border border-teal-100 bg-gradient-to-b from-white to-teal-50/30 p-6 shadow-sm">
                <div class="flex justify-center mb-4">
                    <div class="inline-flex group">@include('landing.partials.mega-svg-schemat')</div>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">{{ __('landing.index.feat_schemat_title') }}</h3>
                <p class="text-slate-800 font-medium mb-4">{{ __('landing.index.feat_schemat_text') }}</p>
                <a href="{{ LandingAlternateUrls::funkcjaUrl('schemat') }}" class="text-sm font-bold text-teal-800 hover:text-teal-950 underline underline-offset-2 decoration-teal-300">{{ __('landing.index.card_read_more') }}</a>
            </div>
            <div id="przeglad" class="text-center scroll-mt-24 rounded-2xl border border-fuchsia-100 bg-gradient-to-b from-white to-fuchsia-50/20 p-6 shadow-sm">
                <div class="flex justify-center mb-4">
                    <div class="inline-flex group">@include('landing.partials.mega-svg-przeglad')</div>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">{{ __('landing.index.feat_przeglad_title') }}</h3>
                <p class="text-slate-800 font-medium mb-4">{{ __('landing.index.feat_przeglad_text') }}</p>
                <a href="{{ LandingAlternateUrls::funkcjaUrl('przeglad') }}" class="text-sm font-bold text-fuchsia-800 hover:text-fuchsia-950 underline underline-offset-2 decoration-fuchsia-300">{{ __('landing.index.card_read_more') }}</a>
            </div>
        </div>
    </div>
</section>

<section class="py-12 lg:py-16 bg-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-3">{{ __('landing.index.cta2_title') }}</h2>
        <p class="text-slate-800 font-semibold mb-6 max-w-2xl mx-auto">{{ __('landing.index.cta2_sub') }}</p>
        @if(session('uzytkownik_id'))
            <a href="{{ route('kartoteki.pracownicy.index') }}" class="inline-flex items-center px-8 py-4 bg-violet-600 text-white font-bold rounded-lg hover:bg-violet-700 transition shadow-md shadow-violet-600/20">{{ __('landing.index.cta2_kartoteka') }}</a>
        @else
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('rejestracja', ['plan' => 'free']) }}" class="inline-flex items-center px-8 py-4 bg-violet-600 text-white font-bold rounded-lg hover:bg-violet-700 transition shadow-md shadow-violet-600/20">{{ __('landing.index.cta2_free') }}</a>
                <a href="{{ route('cennik') }}" class="inline-flex items-center px-8 py-4 border-2 border-slate-700 text-slate-800 font-bold rounded-lg hover:bg-slate-300/80 transition">{{ __('landing.index.cta2_pricing') }}</a>
            </div>
        @endif
    </div>
</section>
@endsection
