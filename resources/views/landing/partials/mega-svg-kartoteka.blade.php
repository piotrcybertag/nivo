{{-- Ilustracja: kartoteka / relacje — paleta fiolet–indygo–morski (nie jak niebieskie Aveo) --}}
@php
    $box = empty($large) ? 'w-14 h-14' : 'w-full max-w-[200px] aspect-square mx-auto';
@endphp
<div class="{{ $box }} flex items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-violet-100 via-indigo-50 to-teal-50 ring-1 ring-violet-300/70 group-hover:ring-violet-500/60 group-hover:shadow-lg transition">
    <svg class="{{ empty($large) ? 'w-11 h-11' : 'w-[88%] h-[88%]' }}" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <defs>
            <linearGradient id="nivo-k-bg" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#faf5ff"/><stop offset="100%" stop-color="#e0f2fe"/></linearGradient>
            <linearGradient id="nivo-k-card" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#c4b5fd"/><stop offset="100%" stop-color="#6366f1"/></linearGradient>
            <linearGradient id="nivo-k-person" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#5eead4"/><stop offset="100%" stop-color="#0d9488"/></linearGradient>
            <linearGradient id="nivo-k-line" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#a78bfa"/><stop offset="100%" stop-color="#2dd4bf"/></linearGradient>
        </defs>
        <rect x="5" y="6" width="38" height="36" rx="5" fill="url(#nivo-k-bg)" stroke="#a78bfa" stroke-width="1.1" opacity="0.85"/>
        <rect x="14" y="9" width="20" height="8" rx="2" fill="url(#nivo-k-card)" opacity="0.95"/>
        <text x="24" y="14.5" text-anchor="middle" font-size="4" font-weight="800" fill="white">HR</text>
        <path d="M24 17v5" stroke="url(#nivo-k-line)" stroke-width="1.4" stroke-linecap="round"/>
        <path d="M24 22 L12 28 M24 22 L24 28 M24 22 L36 28" stroke="url(#nivo-k-line)" stroke-width="1.2" stroke-linecap="round"/>
        <rect x="7" y="30" width="10" height="12" rx="2" fill="white" stroke="#818cf8" stroke-width="0.9"/>
        <circle cx="12" cy="34" r="2.2" fill="url(#nivo-k-person)"/>
        <path d="M9.5 38.5h5" stroke="#475569" stroke-width="0.8" stroke-linecap="round"/>
        <rect x="19" y="30" width="10" height="12" rx="2" fill="white" stroke="#818cf8" stroke-width="0.9"/>
        <circle cx="24" cy="34" r="2.2" fill="url(#nivo-k-person)"/>
        <rect x="31" y="30" width="10" height="12" rx="2" fill="white" stroke="#818cf8" stroke-width="0.9"/>
        <circle cx="36" cy="34" r="2.2" fill="url(#nivo-k-person)"/>
        <rect x="38" y="8" width="7" height="7" rx="3.5" fill="#f472b6" stroke="#db2777" stroke-width="0.6"/>
        <path d="M41.5 10.2v2.3M40.3 11.4h2.4" stroke="white" stroke-width="0.9" stroke-linecap="round"/>
    </svg>
</div>
