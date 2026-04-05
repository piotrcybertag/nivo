@php
    /** @var array{pl_path: string, en_path: string, es_path: string, fr_path: string, de_path: string} $landingLocaleSwitch */
    $loc = $landingLocale ?? 'pl';
    $isPl = $loc === 'pl';
    $isEn = $loc === 'en';
    $isEs = $loc === 'es';
    $isFr = $loc === 'fr';
    $isDe = $loc === 'de';
    $urlPl = route('landing.set_locale', ['locale' => 'pl', 'next' => $landingLocaleSwitch['pl_path']]);
    $urlEn = route('landing.set_locale', ['locale' => 'en', 'next' => $landingLocaleSwitch['en_path']]);
    $urlEs = route('landing.set_locale', ['locale' => 'es', 'next' => $landingLocaleSwitch['es_path']]);
    $urlFr = route('landing.set_locale', ['locale' => 'fr', 'next' => $landingLocaleSwitch['fr_path']]);
    $urlDe = route('landing.set_locale', ['locale' => 'de', 'next' => $landingLocaleSwitch['de_path']]);
    $compact = $compact ?? false;
@endphp
<details class="lang-switcher group/lang relative z-[70]">
    <summary
        aria-label="{{ __('landing.nav.lang_menu') }}"
        class="flex cursor-pointer items-center gap-2 rounded-full border border-violet-200/90 bg-gradient-to-br from-white via-violet-50/40 to-indigo-50/30 {{ $compact ? 'px-2.5 py-1.5 text-xs' : 'px-3 py-2 text-sm' }} font-semibold text-gray-800 shadow-sm shadow-violet-900/[0.06] outline-none ring-offset-2 ring-offset-white transition hover:border-violet-300 hover:shadow-md hover:shadow-violet-500/10 focus-visible:ring-2 focus-visible:ring-violet-500 [&::-webkit-details-marker]:hidden list-none">
        <span class="flex {{ $compact ? 'h-6 w-6' : 'h-8 w-8' }} shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-violet-600 to-indigo-700 text-white shadow-inner" aria-hidden="true">
            <svg class="{{ $compact ? 'h-3.5 w-3.5' : 'h-4 w-4' }}" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="2" y1="12" x2="22" y2="12"/>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
        </span>
        <span class="max-w-[9rem] truncate sm:max-w-none">@if($isEn){{ __('landing.nav.lang_current_en') }}@elseif($isEs){{ __('landing.nav.lang_current_es') }}@elseif($isFr){{ __('landing.nav.lang_current_fr') }}@elseif($isDe){{ __('landing.nav.lang_current_de') }}@else{{ __('landing.nav.lang_current_pl') }}@endif</span>
        <svg class="lang-switcher-chev {{ $compact ? 'h-3.5 w-3.5' : 'h-4 w-4' }} shrink-0 text-violet-600 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
    </summary>
    <div class="absolute {{ $compact ? 'left-1/2 -translate-x-1/2' : 'right-0' }} top-[calc(100%+0.45rem)] w-[min(17.5rem,calc(100vw-2rem))] origin-top overflow-hidden rounded-2xl border border-violet-100/90 bg-white/95 p-1.5 shadow-2xl shadow-violet-900/20 ring-1 ring-violet-400/15 backdrop-blur-md">
        <p class="px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-violet-600/85">{{ __('landing.nav.lang_menu') }}</p>
        <a href="{{ $urlPl }}" hreflang="pl" lang="pl"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $isPl ? 'bg-gradient-to-r from-violet-100/90 to-indigo-50/90 text-violet-950 shadow-sm ring-1 ring-violet-200/70' : 'text-gray-800 hover:bg-gradient-to-r hover:from-violet-50 hover:to-indigo-50/50' }}">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-lg shadow-sm ring-1 ring-violet-100/80" aria-hidden="true">🇵🇱</span>
            {{ __('landing.nav.lang_switch_pl') }}
            @if($isPl)
                <svg class="ml-auto h-5 w-5 shrink-0 text-violet-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            @endif
        </a>
        <a href="{{ $urlEn }}" hreflang="en" lang="en"
            class="mt-0.5 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $isEn ? 'bg-gradient-to-r from-violet-100/90 to-indigo-50/90 text-violet-950 shadow-sm ring-1 ring-violet-200/70' : 'text-gray-800 hover:bg-gradient-to-r hover:from-violet-50 hover:to-indigo-50/50' }}">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-lg shadow-sm ring-1 ring-violet-100/80" aria-hidden="true">🇬🇧</span>
            {{ __('landing.nav.lang_switch_en') }}
            @if($isEn)
                <svg class="ml-auto h-5 w-5 shrink-0 text-violet-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            @endif
        </a>
        <a href="{{ $urlEs }}" hreflang="es" lang="es"
            class="mt-0.5 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $isEs ? 'bg-gradient-to-r from-violet-100/90 to-indigo-50/90 text-violet-950 shadow-sm ring-1 ring-violet-200/70' : 'text-gray-800 hover:bg-gradient-to-r hover:from-violet-50 hover:to-indigo-50/50' }}">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-lg shadow-sm ring-1 ring-violet-100/80" aria-hidden="true">🇪🇸</span>
            {{ __('landing.nav.lang_switch_es') }}
            @if($isEs)
                <svg class="ml-auto h-5 w-5 shrink-0 text-violet-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            @endif
        </a>
        <a href="{{ $urlFr }}" hreflang="fr" lang="fr"
            class="mt-0.5 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $isFr ? 'bg-gradient-to-r from-violet-100/90 to-indigo-50/90 text-violet-950 shadow-sm ring-1 ring-violet-200/70' : 'text-gray-800 hover:bg-gradient-to-r hover:from-violet-50 hover:to-indigo-50/50' }}">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-lg shadow-sm ring-1 ring-violet-100/80" aria-hidden="true">🇫🇷</span>
            {{ __('landing.nav.lang_switch_fr') }}
            @if($isFr)
                <svg class="ml-auto h-5 w-5 shrink-0 text-violet-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            @endif
        </a>
        <a href="{{ $urlDe }}" hreflang="de" lang="de"
            class="mt-0.5 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $isDe ? 'bg-gradient-to-r from-violet-100/90 to-indigo-50/90 text-violet-950 shadow-sm ring-1 ring-violet-200/70' : 'text-gray-800 hover:bg-gradient-to-r hover:from-violet-50 hover:to-indigo-50/50' }}">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-lg shadow-sm ring-1 ring-violet-100/80" aria-hidden="true">🇩🇪</span>
            {{ __('landing.nav.lang_switch_de') }}
            @if($isDe)
                <svg class="ml-auto h-5 w-5 shrink-0 text-violet-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            @endif
        </a>
        <p class="mt-1.5 border-t border-violet-100/80 px-3 pt-2 text-[10px] leading-snug text-gray-500">{{ __('landing.nav.lang_switch_hint') }}</p>
    </div>
</details>
