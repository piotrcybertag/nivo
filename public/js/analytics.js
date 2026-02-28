/**
 * Google Analytics 4 – event helper.
 * Reuse in other cyberrum apps (empo, opeo): copy this file and load in layout.
 *
 * To add more events: call window.trackEvent('event_name', { param: 'value' }) from
 * your Blade views or after redirects (via flashed session, see layout).
 * GA only runs when configured and in production; safe to call when gtag is absent.
 */
(function () {
    'use strict';

    function trackEvent(name, params) {
        params = params || {};
        if (typeof gtag === 'function') {
            gtag('event', name, params);
        }
    }

    if (typeof window !== 'undefined') {
        window.trackEvent = trackEvent;
    }
})();
