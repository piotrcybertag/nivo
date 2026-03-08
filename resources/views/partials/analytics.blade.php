{{--
    Google Analytics 4 + Google Ads partial.
    Reuse in other cyberrum apps (empo, opeo): copy this partial and include in layout.
    GA4 only runs in production when GA_MEASUREMENT_ID is set in .env / config.
    Google Ads (gtag) always loads.
--}}
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-16480597349"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'AW-16480597349');
</script>
@php
    $gaId = config('services.google_analytics.measurement_id');
    $isProduction = app()->environment('production');
@endphp
@if($gaId && $isProduction)
<script>
    gtag('config', '{{ $gaId }}', {
        anonymize_ip: true
    });
</script>
@endif
