<?php

return [

    'contact_admin_email' => env('NIVO_LANDING_CONTACT_EMAIL', 'info@cyberrum.eu'),

    /** Dane firmy Scout Solutions — blok w stopce landingowej. */
    'scout_contact_email' => env('SCOUT_CONTACT_EMAIL', 'info@scoutsolutions.eu'),

    'cookie_consent_name' => env('NIVO_COOKIE_CONSENT', 'nivo_cookie_consent'),

    /** Minuty ważności cookie po akceptacji (domyślnie ~1 rok). */
    'cookie_consent_minutes' => (int) env('NIVO_COOKIE_CONSENT_MINUTES', 525600),

    /** Minuty ważności po odmowie (krótszy czas — baner wraca wcześniej). */
    'cookie_reject_minutes' => (int) env('NIVO_COOKIE_REJECT_MINUTES', 43200),
];
