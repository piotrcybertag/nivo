@php
    $box = empty($large) ? 'w-14 h-14' : 'w-full max-w-[200px] aspect-square mx-auto';
@endphp
<div class="{{ $box }} flex items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-fuchsia-100 via-rose-50 to-amber-50 ring-1 ring-fuchsia-300/60 group-hover:ring-fuchsia-500/55 group-hover:shadow-lg transition">
    <svg class="{{ empty($large) ? 'w-11 h-11' : 'w-[88%] h-[88%]' }}" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <defs>
            <linearGradient id="nivo-p-frame" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#fdf4ff"/><stop offset="100%" stop-color="#fff7ed"/></linearGradient>
            <linearGradient id="nivo-p-glass" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#e9d5ff"/><stop offset="100%" stop-color="#f472b6"/></linearGradient>
            <pattern id="nivo-p-grid" width="6" height="6" patternUnits="userSpaceOnUse">
                <path d="M6 1H1M1 6V6" stroke="#c4b5fd" stroke-width="0.4" opacity="0.5"/>
            </pattern>
        </defs>
        <rect x="7" y="9" width="34" height="30" rx="3" fill="url(#nivo-p-frame)" stroke="#d946ef" stroke-width="1"/>
        <rect x="10" y="12" width="28" height="24" rx="2" fill="url(#nivo-p-grid)" opacity="0.35"/>
        <rect x="14" y="16" width="6" height="5" rx="1" fill="#a78bfa" opacity="0.7"/>
        <rect x="22" y="16" width="6" height="5" rx="1" fill="#5eead4" opacity="0.75"/>
        <rect x="30" y="16" width="6" height="5" rx="1" fill="#a78bfa" opacity="0.55"/>
        <rect x="14" y="25" width="6" height="5" rx="1" fill="#5eead4" opacity="0.6"/>
        <rect x="22" y="25" width="6" height="5" rx="1" fill="#f472b6" opacity="0.65"/>
        <rect x="30" y="25" width="6" height="5" rx="1" fill="#a78bfa" opacity="0.65"/>
        <circle cx="31" cy="21" r="9" fill="none" stroke="url(#nivo-p-glass)" stroke-width="2.2" opacity="0.95"/>
        <circle cx="31" cy="21" r="5.5" fill="none" stroke="#f9a8d4" stroke-width="1" stroke-dasharray="1.5 2" opacity="0.9"/>
        <path d="M37.5 28.5L41 32" stroke="#7c3aed" stroke-width="2" stroke-linecap="round"/>
        <circle cx="41" cy="32" r="1.8" fill="#7c3aed"/>
        <text x="11" y="40" font-size="3.2" font-weight="800" fill="#9d174d">zoom</text>
    </svg>
</div>
