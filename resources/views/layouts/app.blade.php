@php
    use App\Support\AppUrl;
    use App\Support\LandingAlternateUrls;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.favicon-links')
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <style>
        body.app-shell { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        main.app-main { max-width: none; margin: 0 auto; }
        .schemat-strona { display: flex; gap: 1.5rem; align-items: flex-start; max-width: 100%; }
        .schemat-panel-boczny { flex-shrink: 0; width: 280px; padding: 1rem; background: #fff; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; }
        .schemat-szukaj-form { display: flex; flex-direction: column; gap: 0.5rem; }
        .schemat-szukaj-label { font-size: 0.875rem; font-weight: 500; color: #374151; }
        .schemat-szukaj-input { padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; }
        .schemat-szukaj-btn { padding: 0.5rem 1rem; background: #1e40af; color: #fff; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; align-self: flex-start; }
        .schemat-lista-wynikow { list-style: none; padding: 0; margin: 1rem 0 0; max-height: 60vh; overflow-y: auto; }
        .schemat-lista-wynikow li { margin-bottom: 0.25rem; }
        .schemat-wynik-link { display: block; padding: 0.35rem 0; color: #2563eb; text-decoration: none; font-size: 0.9rem; border-bottom: 1px solid #f3f4f6; }
        .schemat-wynik-link:hover { text-decoration: underline; }
        .schemat-wynik-stanowisko { color: #6b7280; font-size: 0.85em; }
        .schemat-brak-wynikow { margin: 1rem 0 0; font-size: 0.875rem; color: #6b7280; }
        .schemat-wrapper { min-height: 70vh; flex: 1; min-width: 0; display: flex; align-items: center; justify-content: center; overflow: auto; max-height: calc(100vh - 100px); }
        .schemat-root { display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem; }
        .schemat-root--z-nad-szefem { flex-direction: column; align-items: center; }
        .org-connector-wrap-nad-szefem { position: relative; display: flex; flex-direction: column; align-items: center; }
        .org-connector-wrap-nad-szefem > .org-lines-svg { position: absolute; pointer-events: none; overflow: visible; }
        .org-connector-wrap-nad-szefem .schemat-root-pod-nad-szefem { margin-top: 24px; }
        .org-nad-szefem-row { display: flex; flex-direction: row; justify-content: center; align-items: flex-start; gap: 2rem; flex-wrap: wrap; }
        .schemat-root-pod-nad-szefem { display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem; }
        .schemat-box { box-sizing: border-box; width: 220px; height: 120px; border: 2px solid #1e40af; background: #fff; padding: 0.75rem 1rem; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 6px; display: flex; flex-direction: column; justify-content: center; align-items: center; overflow: hidden; }
        .schemat-box.org-box--clickable { display: flex; text-decoration: none; color: inherit; cursor: pointer; transition: background 0.15s, box-shadow 0.15s; }
        .schemat-box.org-box--clickable:hover { background: #eff6ff; box-shadow: 0 4px 12px rgba(30,64,175,0.2); }
        .schemat-box > div { min-width: 0; overflow-wrap: break-word; word-break: break-word; }
        .schemat-pracownicy-total { font-size: 0.7rem; color: #6b7280; margin-bottom: 0.35rem; font-weight: 500; }
        .schemat-name { font-weight: 600; font-size: 0.95rem; line-height: 1.25; color: #111; margin-bottom: 0.25rem; }
        .schemat-stanowisko { font-size: 0.8rem; line-height: 1.3; color: #4b5563; }
        .schemat-podwladni-count { font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem; }
        .schemat-empty { text-align: center; color: #6b7280; max-width: 360px; }
        /* Schemat – drzewo z liniami */
        .org-node { display: flex; flex-direction: column; align-items: center; width: max-content; }
        .org-box--matrix { border-style: dashed; border-color: #6b7280; }
        .org-box--grupa { background: #f0fdf4; border-color: #86efac; }
        .org-connector-wrap { position: relative; display: flex; flex-direction: column; align-items: center; margin-top: 24px; align-self: stretch; }
        .org-connector-wrap > .org-lines-svg { position: absolute; pointer-events: none; overflow: visible; }
        .org-lines-svg path { fill: none; stroke: #374151; stroke-width: 2; }
        .org-lines-svg path.org-line-path--matrix { stroke: #6b7280; stroke-dasharray: 6 4; }
        .org-children { display: flex; flex-direction: column; align-items: center; position: relative; width: 100%; }
        .org-branch { display: grid; grid-template-rows: auto; grid-template-columns: repeat(var(--child-count), 1fr); column-gap: 32px; row-gap: 0; align-items: start; justify-items: center; }
        .org-branch-children { grid-column: 1 / -1; display: grid; grid-template-columns: subgrid; padding-top: 0; }
        .org-branch--multi-row .org-branch-children { grid-template-columns: repeat(4, 1fr); grid-auto-rows: auto; column-gap: 32px; row-gap: 24px; padding-top: 0; }
        .org-branch--vertical .org-branch-children { display: flex; flex-direction: column; align-items: center; gap: 24px; grid-column: 1; grid-template-columns: unset; }
        /* Przegląd – rysunek od góry, rozszerzanie w dół i na boki; zoom od góry */
        .przeglad-page { position: relative; }
        .przeglad-page .schemat-wrapper { align-items: flex-start; justify-content: center; }
        .przeglad-zoom-container { transform-origin: top center; transition: transform 0.15s ease-out; display: inline-block; min-width: min-content; }
        .przeglad-page .schemat-root { justify-content: center; align-items: flex-start; }
        .przeglad-zoom-buttons { position: absolute; bottom: 1rem; right: 1rem; display: flex; gap: 0.5rem; z-index: 10; }
        .przeglad-zoom-btn { width: 40px; height: 40px; border-radius: 50%; border: 2px solid #1e40af; background: #fff; color: #1e40af; font-size: 1.5rem; font-weight: 600; line-height: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.1); transition: background 0.15s, color 0.15s; }
        .przeglad-zoom-btn:hover { background: #1e40af; color: #fff; }
        .przeglad-zoom-out { font-size: 1.75rem; }
    </style>
    @include('partials.analytics')
</head>
<body class="app-shell bg-gray-100 text-gray-900 antialiased min-h-screen flex flex-col">
    <header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm overflow-hidden">
        <nav class="w-full px-4 sm:px-6" aria-label="{{ __('app.nav.aria_menu') }}">
            <div class="flex items-center justify-between h-16 gap-3">
                <div class="flex items-center gap-3 sm:gap-4 lg:gap-6 min-w-0 flex-1">
                    <a href="{{ LandingAlternateUrls::homeUrl() }}" class="relative z-10 flex h-16 items-center shrink-0 gap-2 bg-transparent" aria-label="{{ __('app.nav.aria_home') }}">
                        <img src="{{ asset('storage/nivo.png') }}" alt="Nivo" width="180" height="60" class="h-[3.375rem] sm:h-[3.75rem] w-auto max-h-[3.375rem] sm:max-h-[3.75rem] object-contain object-left bg-transparent select-none" decoding="async">
                        <span class="text-[0.625rem] font-semibold text-gray-500 leading-none shrink-0" title="{{ __('app.nav.version_title') }}">{{ $appVersion ?? '1' }}</span>
                    </a>
                    <div class="hidden md:flex flex-wrap items-center gap-x-4 gap-y-1 lg:gap-x-6 min-w-0">
                        <a href="{{ LandingAlternateUrls::homeUrl() }}" class="text-sm font-semibold text-gray-800 hover:text-violet-700">{{ __('app.nav.brand') }}</a>
                        @if(!session('uzytkownik_id') && !request()->routeIs('pl.rejestracja', 'en.rejestracja', 'es.rejestracja', 'fr.rejestracja', 'de.rejestracja', 'pl.login', 'en.login', 'es.login', 'fr.login', 'de.login'))
                            <a href="{{ AppUrl::route('cennik') }}" class="text-sm font-semibold text-gray-800 hover:text-violet-700">{{ __('app.nav.pricing') }}</a>
                        @endif
                        @if(session('uzytkownik_id'))
                            @if(!session('login_via_link'))
                                <a href="{{ AppUrl::route('kartoteki.pracownicy.index') }}" class="text-sm font-semibold text-gray-800 hover:text-violet-700">{{ __('app.nav.employees') }}</a>
                            @endif
                            <a href="{{ AppUrl::route('schemat') }}" class="text-sm font-semibold text-gray-800 hover:text-violet-700">{{ __('app.nav.org_chart') }}</a>
                            <a href="{{ AppUrl::route('przeglad') }}" target="_blank" class="text-sm font-semibold text-gray-800 hover:text-violet-700">{{ __('app.nav.overview') }}</a>
                            @if(!session('login_via_link'))
                                <a href="{{ AppUrl::route('instrukcja') }}" class="text-sm font-semibold text-gray-800 hover:text-violet-700">{{ __('app.nav.manual') }}</a>
                                @if(session('uzytkownik_typ') !== 'ADM')
                                    <a href="{{ AppUrl::route('ustawienia') }}" class="text-sm font-semibold text-gray-800 hover:text-violet-700">{{ __('app.nav.settings') }}</a>
                                @endif
                            @endif
                            @if(session('uzytkownik_typ') === 'ADM')
                                <a href="{{ AppUrl::route('kartoteki.uzytkownicy.index') }}" class="text-sm font-semibold text-gray-800 hover:text-violet-700">{{ __('app.nav.users') }}</a>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                    @if(session('uzytkownik_id'))
                        @if(!session('login_via_link'))
                            <form method="POST" action="{{ AppUrl::route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-gray-800 hover:text-violet-700 bg-transparent border-0 p-0 cursor-pointer whitespace-nowrap">{{ __('app.nav.logout', ['name' => session('uzytkownik_imie_nazwisko')]) }}</button>
                            </form>
                        @endif
                    @else
                        @if(!request()->routeIs('pl.login', 'en.login', 'es.login', 'fr.login', 'de.login'))
                            <a href="{{ AppUrl::route('login') }}" class="inline-flex items-center px-4 sm:px-5 py-2.5 bg-violet-600 text-white text-sm font-semibold rounded-lg hover:bg-violet-700 transition shadow-sm shadow-violet-600/20">{{ __('app.nav.login') }}</a>
                        @endif
                    @endif
                </div>
            </div>
        </nav>
        <div class="md:hidden border-t border-gray-100 bg-white px-4 py-2 flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-sm font-semibold text-gray-800">
            <a href="{{ LandingAlternateUrls::homeUrl() }}" class="hover:text-violet-700">{{ __('app.nav.brand') }}</a>
            @if(!session('uzytkownik_id') && !request()->routeIs('pl.rejestracja', 'en.rejestracja', 'es.rejestracja', 'fr.rejestracja', 'de.rejestracja', 'pl.login', 'en.login', 'es.login', 'fr.login', 'de.login'))
                <a href="{{ AppUrl::route('cennik') }}" class="hover:text-violet-700">{{ __('app.nav.pricing') }}</a>
            @endif
            @if(session('uzytkownik_id'))
                @if(!session('login_via_link'))
                    <a href="{{ AppUrl::route('kartoteki.pracownicy.index') }}" class="hover:text-violet-700">{{ __('app.nav.employees') }}</a>
                @endif
                <a href="{{ AppUrl::route('schemat') }}" class="hover:text-violet-700">{{ __('app.nav.org_chart') }}</a>
                <a href="{{ AppUrl::route('przeglad') }}" target="_blank" class="hover:text-violet-700">{{ __('app.nav.overview') }}</a>
                @if(!session('login_via_link'))
                    <a href="{{ AppUrl::route('instrukcja') }}" class="hover:text-violet-700">{{ __('app.nav.manual') }}</a>
                    @if(session('uzytkownik_typ') !== 'ADM')
                        <a href="{{ AppUrl::route('ustawienia') }}" class="hover:text-violet-700">{{ __('app.nav.settings') }}</a>
                    @endif
                @endif
                @if(session('uzytkownik_typ') === 'ADM')
                    <a href="{{ AppUrl::route('kartoteki.uzytkownicy.index') }}" class="hover:text-violet-700">{{ __('app.nav.users') }}</a>
                @endif
            @endif
        </div>
    </header>
    <main class="app-main flex-1 w-full p-4 sm:p-6">
        @if (session('error'))
            <div class="max-w-4xl mx-auto mb-4">
                <p class="p-4 bg-red-50 text-red-800 rounded-lg text-sm font-medium border border-red-100">{{ session('error') }}</p>
            </div>
        @endif
        @if (session('success'))
            <div class="max-w-4xl mx-auto mb-4">
                <p class="p-4 bg-emerald-50 text-emerald-900 rounded-lg text-sm font-medium border border-emerald-100">{{ session('success') }}</p>
            </div>
        @endif
        @yield('content')
    </main>
    <script>
    (function() {
        function drawOrgLines() {
            if (document.querySelector('[data-page="schemat"]')) {
            document.querySelectorAll('.org-connector-wrap').forEach(function(wrap) {
                var svg = wrap.querySelector(':scope > .org-lines-svg');
                if (!svg) return;
                var node = wrap.closest('.org-node');
                if (!node) return;
                var bossBox = node.querySelector(':scope > .schemat-box');
                var branch = wrap.querySelector(':scope > .org-children > .org-branch');
                var childNodes = wrap.querySelectorAll('.org-branch-children > .org-node');
                if (!bossBox || !childNodes.length) return;
                var wrapRect = wrap.getBoundingClientRect();
                var nodeRect = node.getBoundingClientRect();
                var bossRect = bossBox.getBoundingClientRect();
                var refLeft = nodeRect.left;
                var refTop = bossRect.bottom;
                var areaW = nodeRect.width;
                var areaH = nodeRect.bottom - refTop;
                if (areaH <= 0) return;
                svg.style.left = (refLeft - wrapRect.left) + 'px';
                svg.style.top = (refTop - wrapRect.top) + 'px';
                svg.setAttribute('width', areaW);
                svg.setAttribute('height', areaH);
                svg.setAttribute('viewBox', '0 0 ' + areaW + ' ' + areaH);
                while (svg.firstChild) svg.removeChild(svg.firstChild);
                var bossCx = bossRect.left + bossRect.width / 2 - refLeft;
                var multiRow = branch && branch.classList.contains('org-branch--multi-row') && childNodes.length > 4;
                var rowMidYs = [];
                if (multiRow) {
                    var cols = 4;
                    var rowTops = [];
                    var rowBottoms = [];
                    for (var r = 0; r * cols < childNodes.length; r++) {
                        rowTops[r] = 1e9;
                        rowBottoms[r] = -1;
                    }
                    for (var i = 0; i < childNodes.length; i++) {
                        var cb = childNodes[i].querySelector('.schemat-box');
                        if (!cb) continue;
                        var cr = cb.getBoundingClientRect();
                        var topY = cr.top - refTop;
                        var bottomY = cr.bottom - refTop;
                        var r = Math.floor(i / cols);
                        if (topY < rowTops[r]) rowTops[r] = topY;
                        if (bottomY > rowBottoms[r]) rowBottoms[r] = bottomY;
                    }
                    for (var r = 0; r < rowTops.length; r++) {
                        if (r === 0) {
                            rowMidYs[r] = rowTops[0] / 2;
                        } else if (rowBottoms[r - 1] >= 0 && rowTops[r] < 1e9) {
                            rowMidYs[r] = (rowBottoms[r - 1] + rowTops[r]) / 2;
                        } else {
                            rowMidYs[r] = rowTops[r] / 2;
                        }
                    }
                }
                [].forEach.call(childNodes, function(childNode, idx) {
                    var childBox = childNode.querySelector('.schemat-box');
                    if (!childBox) return;
                    var childRect = childBox.getBoundingClientRect();
                    var childCx = childRect.left + childRect.width / 2 - refLeft;
                    var childTop = childRect.top - refTop;
                    var midY;
                    var rowIndex = Math.floor(idx / 4);
                    if (rowMidYs.length > 0 && rowMidYs[rowIndex] !== undefined) {
                        midY = rowMidYs[rowIndex];
                    } else {
                        midY = childTop / 2;
                    }
                    var d = 'M ' + bossCx + ',0 L ' + bossCx + ',' + midY + ' L ' + childCx + ',' + midY + ' L ' + childCx + ',' + childTop;
                    var path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path.setAttribute('d', d);
                    path.setAttribute('class', childNode.classList.contains('org-node--matrix') ? 'org-line-path org-line-path--matrix' : 'org-line-path');
                    svg.appendChild(path);
                });
            });
            document.querySelectorAll('.org-connector-wrap-nad-szefem').forEach(function(wrap) {
                var svg = wrap.querySelector(':scope > .org-lines-svg');
                if (!svg) return;
                var bossBoxes = wrap.querySelectorAll('.org-box-nad-szefem');
                var centerBox = wrap.querySelector('.schemat-root-pod-nad-szefem .org-node .schemat-box');
                if (!bossBoxes.length || !centerBox) return;
                var wrapRect = wrap.getBoundingClientRect();
                var centerRect = centerBox.getBoundingClientRect();
                var refLeft = wrapRect.left;
                var refTop = wrapRect.top;
                var areaW = wrapRect.width;
                var areaH = centerRect.top - refTop;
                if (areaH <= 0) return;
                svg.style.left = '0';
                svg.style.top = '0';
                svg.setAttribute('width', areaW);
                svg.setAttribute('height', areaH);
                svg.setAttribute('viewBox', '0 0 ' + areaW + ' ' + areaH);
                while (svg.firstChild) svg.removeChild(svg.firstChild);
                var centerCx = centerRect.left + centerRect.width / 2 - refLeft;
                var centerTop = centerRect.top - refTop;
                [].forEach.call(bossBoxes, function(bossBox) {
                    var bossRect = bossBox.getBoundingClientRect();
                    var bossCx = bossRect.left + bossRect.width / 2 - refLeft;
                    var bossBottom = bossRect.bottom - refTop;
                    var midY = (bossBottom + centerTop) / 2;
                    var d = 'M ' + bossCx + ',' + bossBottom + ' L ' + bossCx + ',' + midY + ' L ' + centerCx + ',' + midY + ' L ' + centerCx + ',' + centerTop;
                    var path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path.setAttribute('d', d);
                    path.setAttribute('class', bossBox.classList.contains('org-box--matrix') ? 'org-line-path org-line-path--matrix' : 'org-line-path');
                    svg.appendChild(path);
                });
            });
            return;
            }
            document.querySelectorAll('.org-connector-wrap').forEach(function(wrap) {
                var svg = wrap.querySelector(':scope > .org-lines-svg');
                if (!svg) return;
                var node = wrap.closest('.org-node');
                if (!node) return;
                var bossBox = node.querySelector(':scope > .schemat-box');
                var branch = wrap.querySelector(':scope > .org-children > .org-branch');
                var branchChildren = wrap.querySelector(':scope > .org-children > .org-branch > .org-branch-children');
                if (!branchChildren) return;
                var childNodes = branchChildren.querySelectorAll(':scope > .org-node');
                if (!bossBox || !childNodes.length) return;
                var wrapRect = wrap.getBoundingClientRect();
                var nodeRect = node.getBoundingClientRect();
                var bossRect = bossBox.getBoundingClientRect();
                var isLastLevel = branch && branch.classList.contains('org-branch--vertical');
                var leftOffset = isLastLevel ? 12 : 0;
                var refLeft = nodeRect.left - leftOffset;
                var refTop = bossRect.bottom;
                var areaW = nodeRect.width + leftOffset;
                var areaH = nodeRect.bottom - refTop;
                if (areaH <= 0) return;
                var bossHeight = bossRect.height;
                var bossMidY = isLastLevel ? -bossHeight / 2 : 0;
                if (isLastLevel) {
                    svg.style.top = (refTop - wrapRect.top + bossMidY) + 'px';
                    svg.setAttribute('height', areaH - bossMidY);
                    svg.setAttribute('viewBox', '0 ' + bossMidY + ' ' + areaW + ' ' + (areaH - bossMidY));
                } else {
                    svg.style.top = (refTop - wrapRect.top) + 'px';
                    svg.setAttribute('height', areaH);
                    svg.setAttribute('viewBox', '0 0 ' + areaW + ' ' + areaH);
                }
                svg.style.left = (refLeft - wrapRect.left) + 'px';
                svg.setAttribute('width', areaW);
                while (svg.firstChild) svg.removeChild(svg.firstChild);
                var bossCx = bossRect.left + bossRect.width / 2 - refLeft;
                var bossLeft = bossRect.left - refLeft;
                var lineOffset = 10;
                if (isLastLevel && childNodes.length > 0) {
                    childNodes.forEach(function(childNode) {
                        var childBox = childNode.querySelector('.schemat-box');
                        if (!childBox) return;
                        var childRect = childBox.getBoundingClientRect();
                        var childLeft = childRect.left - refLeft;
                        var childTop = childRect.top - refTop;
                        var childMidY = childTop + childRect.height / 2;
                        var startX = bossLeft - lineOffset;
                        var d = 'M ' + bossLeft + ',' + bossMidY + ' L ' + startX + ',' + bossMidY + ' L ' + startX + ',' + childMidY + ' L ' + childLeft + ',' + childMidY;
                        var path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                        path.setAttribute('d', d);
                        path.setAttribute('class', childNode.classList.contains('org-node--matrix') ? 'org-line-path org-line-path--matrix' : 'org-line-path');
                        svg.appendChild(path);
                    });
                } else {
                    if (branch && branch.classList.contains('org-branch--vertical') && childNodes.length > 0) {
                        var firstBox = childNodes[0].querySelector('.schemat-box');
                        if (firstBox) {
                            var fr = firstBox.getBoundingClientRect();
                            bossCx = fr.left + fr.width / 2 - refLeft;
                        }
                    }
                    childNodes.forEach(function(childNode) {
                        var childBox = childNode.querySelector('.schemat-box');
                        if (!childBox) return;
                        var childRect = childBox.getBoundingClientRect();
                        var childCx = childRect.left + childRect.width / 2 - refLeft;
                        var childTop = childRect.top - refTop;
                        var midY = childTop / 2;
                        var lineCx = (branch && branch.classList.contains('org-branch--vertical')) ? bossCx : childCx;
                        var d = 'M ' + bossCx + ',0 L ' + bossCx + ',' + midY + ' L ' + lineCx + ',' + midY + ' L ' + childCx + ',' + childTop;
                        var path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                        path.setAttribute('d', d);
                        path.setAttribute('class', childNode.classList.contains('org-node--matrix') ? 'org-line-path org-line-path--matrix' : 'org-line-path');
                        svg.appendChild(path);
                    });
                }
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() { requestAnimationFrame(drawOrgLines); });
        } else {
            requestAnimationFrame(drawOrgLines);
        }
    })();
    (function() {
        var container = document.getElementById('przeglad-zoom-container');
        if (!container) return;
        var scale = 1;
        var min = 0.35;
        var max = 2.5;
        var step = 1.2;
        function applyZoom() {
            container.style.transform = 'scale(' + scale + ')';
        }
        document.querySelector('.przeglad-zoom-in').addEventListener('click', function() {
            scale = Math.min(max, scale * step);
            applyZoom();
        });
        document.querySelector('.przeglad-zoom-out').addEventListener('click', function() {
            scale = Math.max(min, scale / step);
            applyZoom();
        });
    })();
    </script>
    {{-- GA4: load event helper; to add more events, flash 'analytics_event' or 'analytics_events' in controllers (see LoginController, PracownikController, routes web). Reuse in other cyberrum apps by including partials/analytics and this script. --}}
    <script src="{{ asset('js/analytics.js') }}"></script>
    @php
        $analyticsEvents = session('analytics_events') ?: (session('analytics_event') ? [session('analytics_event')] : []);
    @endphp
    @if(count($analyticsEvents) > 0)
    <script>
    (function(){
        var events = @json($analyticsEvents);
        if (typeof window.trackEvent === 'function' && events.length) {
            events.forEach(function(e) { window.trackEvent(e.name || e, e.params || {}); });
        }
    })();
    </script>
    @endif
</body>
</html>
