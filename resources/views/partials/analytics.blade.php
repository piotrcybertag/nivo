{{--
    Google Analytics 4 partial.
    Reuse in other cyberrum apps (empo, opeo): copy this partial and include in layout.
    Only runs in production when GA_MEASUREMENT_ID is set in .env / config.
--}}
@php
    $gaId = config('services.google_analytics.measurement_id');
    $isProduction = app()->environment('production');
@endphp
@if($gaId && $isProduction)
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){ dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', '{{ $gaId }}', {
        anonymize_ip: true
    });
</script>
@endif
