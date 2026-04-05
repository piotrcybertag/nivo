<!DOCTYPE html>
<html lang="{{ __('landing.html_lang') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.favicon-links')
@php
    use App\Support\LandingAlternateUrls;
    use Illuminate\Support\Facades\View;
    $baseUrl = rtrim((string) config('app.url'), '/');
    $seoTitle = trim(preg_replace('/\s+/u', ' ', trim(__('landing.meta.base_title').' '.trim((string) (View::getSection('title') ?? '')))));
    $seoDesc = trim((string) (View::getSection('meta_description') ?? ''));
    if ($seoDesc === '') {
        $seoDesc = __('landing.meta.description_default');
    }
    $seoUrl = url()->current();
    $seoImage = $baseUrl.'/storage/nivo.png';
    $ogLocale = match (app()->getLocale()) {
        'en' => 'en_US',
        'es' => 'es_ES',
        'fr' => 'fr_FR',
        'de' => 'de_DE',
        default => 'pl_PL',
    };
    $ogLocaleAlternates = collect(['pl_PL', 'en_US', 'es_ES', 'fr_FR', 'de_DE'])->reject(fn ($v) => $v === $ogLocale)->values()->all();
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => __('landing.seo.og_site_name'),
        'url' => $baseUrl,
        'description' => $seoDesc,
        'inLanguage' => [match (app()->getLocale()) {
            'en' => 'en-US',
            'es' => 'es-ES',
            'fr' => 'fr-FR',
            'de' => 'de-DE',
            default => 'pl-PL',
        }],
        'publisher' => [
            '@type' => 'Organization',
            'name' => __('landing.seo.og_site_name'),
            'url' => $baseUrl,
        ],
    ];
@endphp
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDesc }}">
    <meta name="robots" content="{{ __('landing.seo.robots') }}">
    <link rel="canonical" href="{{ $seoUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ __('landing.seo.og_site_name') }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDesc }}">
    <meta property="og:url" content="{{ $seoUrl }}">
    <meta property="og:locale" content="{{ $ogLocale }}">
    @foreach($ogLocaleAlternates as $ogAlt)
    <meta property="og:locale:alternate" content="{{ $ogAlt }}">
    @endforeach
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:image:alt" content="{{ __('landing.seo.og_image_alt') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDesc }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
    <script type="application/ld+json">@json($jsonLd)</script>
@if(!empty($landingAlternateUrls['pl']))
    <link rel="alternate" hreflang="pl" href="{{ $landingAlternateUrls['pl'] }}">
@endif
@if(!empty($landingAlternateUrls['en']))
    <link rel="alternate" hreflang="en" href="{{ $landingAlternateUrls['en'] }}">
@endif
@if(!empty($landingAlternateUrls['es']))
    <link rel="alternate" hreflang="es" href="{{ $landingAlternateUrls['es'] }}">
@endif
@if(!empty($landingAlternateUrls['fr']))
    <link rel="alternate" hreflang="fr" href="{{ $landingAlternateUrls['fr'] }}">
@endif
@if(!empty($landingAlternateUrls['de']))
    <link rel="alternate" hreflang="de" href="{{ $landingAlternateUrls['de'] }}">
@endif
@if(!empty($landingAlternateUrls['pl']))
    <link rel="alternate" hreflang="x-default" href="{{ $landingAlternateUrls['pl'] }}">
@endif
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <style>
        body.landing-body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        .mega-menu { display: none; position: fixed; left: 0; right: 0; width: 100%; min-width: 100vw; }
        .nav-item-mega:hover .mega-menu,
        .mega-menu:hover { display: block; }
        .nav-link:hover { color: #6d28d9; }
        .nav-item-mega .nav-link { border-bottom: 2px solid transparent; }
        .nav-item-mega:hover .nav-link,
        .nav-item-mega .nav-link.active { color: #6d28d9; border-bottom-color: #6d28d9; }
        .lang-switcher > summary::-webkit-details-marker { display: none; }
        .lang-switcher[open] .lang-switcher-chev { transform: rotate(180deg); }
    </style>
    @include('partials.analytics')
</head>
<body class="landing-body bg-gray-100 text-gray-900 antialiased min-h-screen flex flex-col">
    <header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm overflow-visible">
        <nav class="w-full px-4 sm:px-6" aria-label="{{ __('landing.nav.home_short') }}">
            <div class="flex items-center justify-between h-16 overflow-visible">
                <div class="flex items-center gap-4 lg:gap-6 min-w-0">
                    <a href="{{ LandingAlternateUrls::homeUrl() }}" class="relative z-10 flex h-16 items-center shrink-0 bg-transparent" aria-label="{{ __('landing.nav.home_short') }}">
                        <img src="{{ asset('storage/nivo.png') }}" alt="Nivo" width="180" height="60" class="h-[3.375rem] sm:h-[3.75rem] w-auto max-h-[3.375rem] sm:max-h-[3.75rem] object-contain object-left bg-transparent select-none" decoding="async">
                    </a>
                    <div class="hidden md:flex items-center gap-4 lg:gap-6">
                    <div class="nav-item-mega relative">
                        <a href="#" class="nav-link active py-4 inline-flex items-center text-sm font-semibold text-gray-800">
                            {{ __('landing.nav.features') }}
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        <div class="mega-menu top-full bg-white border-b border-gray-200 shadow-xl" style="top: 64px;">
                            <div class="w-full max-w-[1400px] mx-auto px-6 sm:px-8 lg:px-12 py-8">
                                <div class="flex gap-12">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-xl font-bold text-gray-900 mb-6">{{ __('landing.mega.intro') }}</h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                            <a href="{{ LandingAlternateUrls::funkcjaUrl('kartoteka') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-white to-violet-50/40 ring-1 ring-violet-100 hover:ring-violet-300 hover:shadow-md transition min-w-0">
                                                <div class="mb-3">@include('landing.partials.mega-svg-kartoteka')</div>
                                                <h4 class="font-semibold text-gray-900 mb-1">{{ __('landing.features.kartoteka.title') }}</h4>
                                                <p class="text-sm text-gray-800 font-medium leading-relaxed">{{ __('landing.features.kartoteka.desc') }}</p>
                                            </a>
                                            <a href="{{ LandingAlternateUrls::funkcjaUrl('schemat') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-white to-teal-50/40 ring-1 ring-teal-100 hover:ring-teal-300 hover:shadow-md transition min-w-0">
                                                <div class="mb-3">@include('landing.partials.mega-svg-schemat')</div>
                                                <h4 class="font-semibold text-gray-900 mb-1">{{ __('landing.features.schemat.title') }}</h4>
                                                <p class="text-sm text-gray-800 font-medium leading-relaxed">{{ __('landing.features.schemat.desc') }}</p>
                                            </a>
                                            <a href="{{ LandingAlternateUrls::funkcjaUrl('przeglad') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-white to-fuchsia-50/35 ring-1 ring-fuchsia-100 hover:ring-fuchsia-300 hover:shadow-md transition min-w-0 sm:col-span-2 lg:col-span-1">
                                                <div class="mb-3">@include('landing.partials.mega-svg-przeglad')</div>
                                                <h4 class="font-semibold text-gray-900 mb-1">{{ __('landing.features.przeglad.title') }}</h4>
                                                <p class="text-sm text-gray-800 font-medium leading-relaxed">{{ __('landing.features.przeglad.desc') }}</p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="w-80 flex-shrink-0 bg-gray-100 rounded-xl p-6 hidden lg:block">
                                        <h4 class="font-bold text-gray-900 mb-2">{{ __('landing.mega.sidebar_title') }}</h4>
                                        <p class="text-sm text-gray-800 font-medium mb-4">{{ __('landing.mega.sidebar_text') }}</p>
                                        @if(session('uzytkownik_id'))
                                            <a href="{{ LandingAlternateUrls::appSchematUrl() }}" class="inline-block w-full text-center py-3 px-4 border-2 border-gray-800 rounded-lg font-medium hover:bg-gray-50 transition">{{ __('landing.nav.back_app') }}</a>
                                        @else
                                            <a href="{{ LandingAlternateUrls::rejestracjaUrl('free') }}" class="inline-block w-full text-center py-3 px-4 border-2 border-gray-800 rounded-lg font-medium hover:bg-gray-50 transition">{{ __('landing.mega.sidebar_cta_guest') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item-mega relative">
                        <a href="#" class="nav-link py-4 inline-flex items-center text-sm font-semibold text-gray-800">
                            {{ __('landing.nav.pricing') }}
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        <div class="mega-menu top-full bg-white border-b border-gray-200 shadow-xl" style="top: 64px;">
                            <div class="w-full max-w-[1200px] mx-auto px-6 sm:px-8 lg:px-12 py-8">
                                <div class="flex gap-10">
                                    <div class="flex-1 min-w-0">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 items-stretch">
                                            <div class="p-5 rounded-xl border-2 border-teal-200/80 bg-gradient-to-br from-teal-50/50 to-white hover:border-teal-400 hover:shadow-md transition flex flex-col">
                                                <div class="w-10 h-10 mb-3 flex items-center justify-center rounded-lg bg-gradient-to-br from-teal-200 to-cyan-300 shadow-sm">
                                                    <svg class="w-6 h-6 text-teal-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                </div>
                                                <h4 class="font-bold text-gray-900 mb-1">{{ __('landing.pricing.free_title') }}</h4>
                                                <p class="text-sm text-gray-800 font-medium mb-4">{{ __('landing.pricing.free_desc') }}</p>
                                                <p class="text-xs text-gray-600 font-medium mb-2">{{ __('landing.pricing.free_b1') }}</p>
                                                <p class="text-xs text-gray-600 font-medium mb-4">{{ __('landing.pricing.free_b2') }}</p>
                                                <p class="text-lg font-bold text-gray-900 mb-auto">{{ __('landing.pricing.free_price') }}</p>
                                                <a href="{{ LandingAlternateUrls::rejestracjaUrl('free') }}" class="inline-block w-full text-center py-2.5 px-4 mt-4 border-2 border-teal-500 text-teal-800 font-semibold rounded-lg hover:bg-teal-50 transition">{{ __('landing.pricing.free_cta') }}</a>
                                            </div>
                                            <div class="p-5 rounded-xl border-2 border-violet-300 bg-gradient-to-br from-violet-50/80 to-indigo-50/40 hover:border-violet-500 transition flex flex-col shadow-sm">
                                                <div class="w-10 h-10 mb-3 flex items-center justify-center rounded-lg bg-gradient-to-br from-violet-400 to-indigo-600 shadow">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                                </div>
                                                <h4 class="font-bold text-gray-900 mb-1">{{ __('landing.pricing.full_title') }}</h4>
                                                <p class="text-sm text-gray-800 font-medium mb-4">{{ __('landing.pricing.full_desc') }}</p>
                                                <p class="text-xs text-gray-600 font-medium mb-1">{{ __('landing.pricing.full_b1') }}</p>
                                                <p class="text-xs text-gray-600 font-medium mb-4">{{ __('landing.pricing.full_b2') }}</p>
                                                <p class="text-lg font-bold text-gray-900 mb-1">{{ __('landing.pricing.full_price') }}</p>
                                                <p class="text-sm font-medium text-gray-600 mb-auto">{{ __('landing.pricing.full_yearly') }}</p>
                                                <a href="{{ LandingAlternateUrls::rejestracjaUrl('full') }}" class="inline-block w-full text-center py-2.5 px-4 mt-4 bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-violet-700 hover:to-indigo-700 transition">{{ __('landing.pricing.full_cta') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-72 flex-shrink-0 bg-gradient-to-br from-slate-50 via-violet-50 to-teal-50 rounded-xl p-6 ring-1 ring-violet-100">
                                        <h4 class="font-bold text-gray-900 mb-2">{{ __('landing.pricing.compare_title') }}</h4>
                                        <p class="text-sm text-gray-800 font-medium mb-4">{{ __('landing.pricing.compare_text') }}</p>
                                        <a href="{{ LandingAlternateUrls::cennikUrl() }}" class="inline-block w-full text-center py-3 px-4 border-2 border-gray-800 rounded-lg font-semibold hover:bg-gray-100 transition">{{ __('landing.pricing.compare_cta') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
                    <div class="hidden md:block">
                        @include('landing.partials.lang-switcher', ['compact' => false])
                    </div>
                    @if(session('uzytkownik_id'))
                        <a href="{{ LandingAlternateUrls::appSchematUrl() }}" class="inline-flex items-center px-4 sm:px-5 py-2.5 bg-violet-600 text-white text-sm font-semibold rounded-lg hover:bg-violet-700 transition shadow-sm shadow-violet-600/20">{{ __('landing.nav.back_app') }}</a>
                    @else
                        <a href="{{ LandingAlternateUrls::loginUrl() }}" class="text-sm font-semibold text-gray-800 hover:text-violet-700 hidden sm:inline">{{ __('landing.nav.login') }}</a>
                        <a href="{{ LandingAlternateUrls::rejestracjaUrl('free') }}" class="inline-flex items-center px-4 sm:px-5 py-2.5 bg-violet-600 text-white text-sm font-semibold rounded-lg hover:bg-violet-700 transition shadow-sm shadow-violet-600/20">{{ __('landing.nav.register') }}</a>
                    @endif
                </div>
            </div>
        </nav>
        <div class="md:hidden border-t border-gray-100 bg-white px-4 py-2 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm font-semibold text-gray-800">
            <a href="{{ LandingAlternateUrls::featureAnchorUrl('funkcje') }}" class="hover:text-violet-700">{{ __('landing.nav.features') }}</a>
            <a href="{{ LandingAlternateUrls::cennikUrl() }}" class="hover:text-violet-700">{{ __('landing.nav.pricing') }}</a>
            @include('landing.partials.lang-switcher', ['compact' => true])
        </div>
    </header>

    <main class="flex-1">
        @if (session('error'))
            <div class="max-w-4xl mx-auto px-4 pt-4">
                <p class="p-4 bg-red-50 text-red-800 rounded-lg text-sm font-medium border border-red-100">{{ session('error') }}</p>
            </div>
        @endif
        @if (session('success') && !session('landing_contact_success'))
            <div class="max-w-4xl mx-auto px-4 pt-4">
                <p class="p-4 bg-emerald-50 text-emerald-900 rounded-lg text-sm font-medium border border-emerald-100">{{ session('success') }}</p>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="mt-auto">
        <div class="h-1 bg-gradient-to-r from-violet-500 via-fuchsia-500 to-teal-500"></div>
        <div class="bg-[#1a2b4b] text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-14">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
                    <div class="lg:col-span-2">
                        <a href="{{ LandingAlternateUrls::homeUrl() }}" class="inline-block mb-4">
                            <img src="{{ asset('storage/nivo.png') }}" alt="Nivo" width="180" height="60" class="h-16 sm:h-20 w-auto max-h-20 object-contain object-left bg-transparent" loading="lazy" decoding="async">
                        </a>
                    </div>
                    <div>
                        <h4 class="font-bold text-white mb-2">{{ __('landing.footer.about_title') }}</h4>
                        <p class="text-sm text-white/80 leading-relaxed">{{ __('landing.footer.about_text') }}</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-white mb-2">{{ __('landing.footer.features_title') }}</h4>
                        <p class="text-sm text-white/80 leading-relaxed">{{ __('landing.footer.features_text') }}</p>
                    </div>
                </div>

                <div class="mt-10 pt-10 border-t border-white/15">
                    <h4 class="font-bold text-white mb-4">{{ __('landing.footer.contact_title') }}</h4>
                    <div class="grid md:grid-cols-2 gap-8 lg:gap-10">
                        <div class="space-y-3">
                            <img src="{{ asset('images/scout-solutions-logo-white.png') }}" alt="{{ __('landing.footer.scout_logo_alt') }}" class="h-10 sm:h-11 w-auto max-w-[min(100%,320px)]" width="320" height="111" loading="lazy" decoding="async">
                            <p class="text-sm font-medium text-white">{{ __('landing.footer.scout_company') }}</p>
                            <p class="text-sm text-white/80">{{ __('landing.footer.scout_address') }}</p>
                            <p class="text-sm text-white/80">{{ __('landing.footer.scout_nip') }}</p>
                            <p class="text-sm text-white/80">
                                <a href="mailto:{{ config('nivo_landing.scout_contact_email') }}" class="text-white underline decoration-white/40 underline-offset-2 hover:text-white hover:decoration-white">{{ config('nivo_landing.scout_contact_email') }}</a>
                            </p>
                            <p class="text-xs text-white/60 pt-2 border-t border-white/10">{{ __('landing.footer.contact_product_hint') }}</p>
                            <p class="text-xs text-white/60">
                                <a href="mailto:{{ config('nivo_landing.contact_admin_email') }}" class="underline decoration-white/30 underline-offset-2 hover:text-white/90">{{ config('nivo_landing.contact_admin_email') }}</a>
                                <span class="text-white/40"> · </span>
                                <span>nivo.cyberrum.eu</span>
                            </p>
                        </div>
                        <div>
                            @if(session('landing_contact_success'))
                                <p class="text-sm text-emerald-300 mb-4" role="status">{{ __('landing.footer.success') }}</p>
                            @endif
                            @if(session('landing_contact_error'))
                                <p class="text-sm text-red-300 mb-4" role="alert">{{ session('landing_contact_error') }}</p>
                            @endif
                            <form method="post" action="{{ LandingAlternateUrls::contactFormAction() }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="landing-contact-name" class="block text-xs font-medium text-white/90 mb-1">{{ __('landing.footer.form_name') }}</label>
                                    <input type="text" name="name" id="landing-contact-name" value="{{ old('name') }}" required autocomplete="name"
                                        class="w-full rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/40 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent">
                                    @error('name')<p class="text-xs text-red-300 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="landing-contact-email" class="block text-xs font-medium text-white/90 mb-1">{{ __('landing.footer.form_email') }}</label>
                                    <input type="email" name="email" id="landing-contact-email" value="{{ old('email') }}" required autocomplete="email"
                                        class="w-full rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/40 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent">
                                    @error('email')<p class="text-xs text-red-300 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="landing-contact-message" class="block text-xs font-medium text-white/90 mb-1">{{ __('landing.footer.form_message') }}</label>
                                    <textarea name="message" id="landing-contact-message" rows="4" required
                                        class="w-full rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/40 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent resize-y min-h-[100px]">{{ old('message') }}</textarea>
                                    @error('message')<p class="text-xs text-red-300 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="flex items-start gap-2">
                                    <input type="checkbox" name="rodo" id="landing-contact-rodo" value="1" {{ old('rodo') ? 'checked' : '' }} required
                                        class="mt-1 h-4 w-4 shrink-0 rounded border-white/40 bg-white/10 text-violet-400 focus:ring-violet-400">
                                    <label for="landing-contact-rodo" class="text-xs text-white/75 leading-snug">{{ __('landing.footer.form_rodo') }}</label>
                                </div>
                                @error('rodo')<p class="text-xs text-red-300">{{ $message }}</p>@enderror
                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-violet-600 text-white text-sm font-semibold hover:bg-violet-500 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#1a2b4b] focus:ring-violet-400">{{ __('landing.footer.form_submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 bg-[#0d1f3c]">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 md:gap-6">
                            <div class="flex flex-wrap items-center gap-1 sm:gap-2 px-2 sm:px-3 py-1.5 border border-white/30 rounded text-sm text-white/90" role="navigation" aria-label="Language">
                                <a href="{{ route('landing.set_locale', ['locale' => 'pl', 'next' => $landingLocaleSwitch['pl_path']]) }}" lang="pl" class="px-2 py-0.5 rounded {{ ($landingLocale ?? 'pl') === 'pl' ? 'bg-white/20 text-white font-semibold' : 'text-white/75 hover:text-white' }}">{{ __('landing.footer.lang_pl') }}</a>
                                <span class="text-white/40" aria-hidden="true">|</span>
                                <a href="{{ route('landing.set_locale', ['locale' => 'en', 'next' => $landingLocaleSwitch['en_path']]) }}" lang="en" class="px-2 py-0.5 rounded {{ ($landingLocale ?? 'pl') === 'en' ? 'bg-white/20 text-white font-semibold' : 'text-white/75 hover:text-white' }}">{{ __('landing.footer.lang_en') }}</a>
                                <span class="text-white/40" aria-hidden="true">|</span>
                                <a href="{{ route('landing.set_locale', ['locale' => 'es', 'next' => $landingLocaleSwitch['es_path']]) }}" lang="es" class="px-2 py-0.5 rounded {{ ($landingLocale ?? 'pl') === 'es' ? 'bg-white/20 text-white font-semibold' : 'text-white/75 hover:text-white' }}">{{ __('landing.footer.lang_es') }}</a>
                                <span class="text-white/40" aria-hidden="true">|</span>
                                <a href="{{ route('landing.set_locale', ['locale' => 'fr', 'next' => $landingLocaleSwitch['fr_path']]) }}" lang="fr" class="px-2 py-0.5 rounded {{ ($landingLocale ?? 'pl') === 'fr' ? 'bg-white/20 text-white font-semibold' : 'text-white/75 hover:text-white' }}">{{ __('landing.footer.lang_fr') }}</a>
                                <span class="text-white/40" aria-hidden="true">|</span>
                                <a href="{{ route('landing.set_locale', ['locale' => 'de', 'next' => $landingLocaleSwitch['de_path']]) }}" lang="de" class="px-2 py-0.5 rounded {{ ($landingLocale ?? 'pl') === 'de' ? 'bg-white/20 text-white font-semibold' : 'text-white/75 hover:text-white' }}">{{ __('landing.footer.lang_de') }}</a>
                            </div>
                            <a href="{{ LandingAlternateUrls::policyUrl() }}" class="text-sm text-white/80 hover:text-white">{{ __('landing.footer.privacy') }}</a>
                            <a href="{{ LandingAlternateUrls::termsUrl() }}" class="text-sm text-white/80 hover:text-white">{{ __('landing.footer.terms') }}</a>
                            <span class="text-sm text-white/70">{{ __('landing.footer.copyright', ['year' => date('Y')]) }}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="https://cyberrum.eu" rel="noopener noreferrer" class="w-9 h-9 rounded-full border border-white/30 flex items-center justify-center text-white/80 hover:bg-white/10 hover:text-white transition" aria-label="cyberrum"><span class="text-xs font-bold">cr</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @include('partials.cookie-consent-banner')
</body>
</html>
