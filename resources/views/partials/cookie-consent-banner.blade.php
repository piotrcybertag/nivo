@php
    use App\Support\CookieConsent;
    use App\Support\LandingAlternateUrls;
    $showServer = CookieConsent::shouldShowBanner(request());
    $consentCookieName = config('nivo_landing.cookie_consent_name');
@endphp
<div id="nivo-cookie-banner-root"
     class="{{ $showServer ? '' : 'hidden' }}"
     data-cookie-name="{{ e($consentCookieName) }}"
     role="presentation">
    <style>
        @keyframes nivo-cookie-in {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
        .nivo-cookie-strip { animation: nivo-cookie-in 0.38s ease-out both; }
    </style>
    <div class="nivo-cookie-strip fixed bottom-0 left-0 right-0 z-[100] bg-gray-900 text-white shadow-[0_-8px_30px_rgba(0,0,0,0.2)] border-t border-white/10 px-4 py-4 sm:py-5" role="dialog" aria-labelledby="nivo-cookie-title">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="text-sm text-gray-200 leading-relaxed sm:pr-6">
                <p id="nivo-cookie-title" class="font-semibold text-white mb-1">{{ __('landing.cookie.title') }}</p>
                <p>{!! __('landing.cookie.full_html', [
                    'link' => '<a href="'.e(LandingAlternateUrls::policyUrl()).'" class="text-violet-300 hover:underline underline-offset-2">'.e(__('landing.cookie.privacy_link')).'</a>',
                ]) !!}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:flex-shrink-0">
                <form method="post" action="{{ LandingAlternateUrls::cookieConsentUrl() }}" class="inline">
                    @csrf
                    <input type="hidden" name="decision" value="accept">
                    <button type="submit" class="w-full sm:w-auto min-h-[44px] px-5 py-2.5 rounded-lg bg-violet-600 hover:bg-violet-500 font-semibold text-white text-sm transition">{{ __('landing.cookie.accept') }}</button>
                </form>
                <form method="post" action="{{ LandingAlternateUrls::cookieConsentUrl() }}" class="inline">
                    @csrf
                    <input type="hidden" name="decision" value="reject">
                    <button type="submit" class="w-full sm:w-auto min-h-[44px] px-5 py-2.5 rounded-lg bg-white/10 hover:bg-white/20 font-semibold text-white text-sm border border-white/20 transition">{{ __('landing.cookie.reject') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
(function () {
    var root = document.getElementById('nivo-cookie-banner-root');
    if (!root) return;
    var nm = root.getAttribute('data-cookie-name');
    if (!nm) return;
    function consentCookieVisible() {
        var parts = document.cookie ? document.cookie.split(';') : [];
        for (var i = 0; i < parts.length; i++) {
            var c = parts[i].trim();
            if (c.substring(0, nm.length + 1) === nm + '=') return true;
        }
        return false;
    }
    if (consentCookieVisible()) {
        root.classList.add('hidden');
    } else {
        root.classList.remove('hidden');
    }
})();
</script>
