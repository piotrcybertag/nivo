@php
    $box = empty($large) ? 'w-14 h-14' : 'w-full max-w-[200px] aspect-square mx-auto';
@endphp
<div class="{{ $box }} flex items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-teal-100 via-emerald-50 to-violet-100 ring-1 ring-teal-300/70 group-hover:ring-teal-500/55 group-hover:shadow-lg transition">
    <svg class="{{ empty($large) ? 'w-11 h-11' : 'w-[88%] h-[88%]' }}" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <defs>
            <linearGradient id="nivo-s-root" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#2dd4bf"/><stop offset="100%" stop-color="#4f46e5"/></linearGradient>
            <linearGradient id="nivo-s-node" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#a7f3d0"/><stop offset="100%" stop-color="#34d399"/></linearGradient>
            <linearGradient id="nivo-s-node2" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#ddd6fe"/><stop offset="100%" stop-color="#a78bfa"/></linearGradient>
        </defs>
        <rect x="6" y="5" width="36" height="38" rx="4" fill="#ecfdf5" stroke="#5eead4" stroke-width="1" opacity="0.9"/>
        <rect x="17" y="8" width="14" height="9" rx="2.2" fill="url(#nivo-s-root)"/>
        <text x="24" y="14" text-anchor="middle" font-size="3.8" font-weight="800" fill="white">CEO</text>
        <path d="M24 17v5" stroke="#6366f1" stroke-width="1.3" stroke-linecap="round"/>
        <path d="M11 26h26" stroke="#6366f1" stroke-width="1.1" stroke-linecap="round" opacity="0.6"/>
        <path d="M11 26v3M24 26v3M37 26v3" stroke="#6366f1" stroke-width="1.1" stroke-linecap="round" opacity="0.6"/>
        <rect x="6" y="31" width="11" height="10" rx="1.8" fill="url(#nivo-s-node)" stroke="#059669" stroke-width="0.7"/>
        <rect x="18.5" y="31" width="11" height="10" rx="1.8" fill="url(#nivo-s-node2)" stroke="#7c3aed" stroke-width="0.7"/>
        <rect x="31" y="31" width="11" height="10" rx="1.8" fill="url(#nivo-s-node)" stroke="#059669" stroke-width="0.7"/>
        <text x="11.5" y="37.5" text-anchor="middle" font-size="3" font-weight="800" fill="#064e3b">A1</text>
        <text x="24" y="37.5" text-anchor="middle" font-size="3" font-weight="800" fill="#5b21b6">A2</text>
        <text x="36.5" y="37.5" text-anchor="middle" font-size="3" font-weight="800" fill="#064e3b">A3</text>
        <circle cx="40" cy="11" r="4" fill="#fef08a" stroke="#ca8a04" stroke-width="0.7"/>
        <path d="M39 10.5l1.5 1.5L43 9" stroke="#854d0e" stroke-width="1" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</div>
