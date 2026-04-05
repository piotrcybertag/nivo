<?php

return [
    'upgrade_page_title' => 'Upgrade — Nivo',
    'upgrade_heading' => 'Upgrade to the Full plan',
    'plan_full' => 'Full plan',
    'price_line' => '€3 / month',
    'paid_yearly' => 'Billed yearly (€36).',
    'upgrade_description' => 'Unlimited employees. Full directory, org chart, and overview — no 10-person cap. Checkout opens in the same tab; when you return from Stripe, the Full plan is activated and your session is restored.',
    'upgrade_cta' => 'Choose Full — pay with Stripe',

    'success_return_page_title' => 'Payment — Full plan — Nivo',
    'thanks_page_title' => 'Payment complete — Nivo',
    'thanks_heading' => 'Thank you for your payment',
    'thanks_accepted' => 'Your Full plan payment has been received.',
    'thanks_click_activate' => 'Click below to enable the Full plan on your account:',
    'thanks_btn_activate' => 'Activate Full plan',
    'thanks_full_active' => 'Your Full plan is already active.',
    'thanks_login_hint' => 'Sign in to your account to activate the Full plan (or come back later — you can use the “Upgrade” link in the menu).',
    'back_home' => '← Back to home',

    'return' => [
        'sukces' => [
            'title' => 'Thank you for your payment',
            'p1' => 'The Full plan is now active for <strong>:name</strong>. You are signed back in — you can use the app without an employee limit.',
            'p2' => 'Your session was refreshed; you do not need to sign in again.',
            'cta' => 'Open the app',
        ],
        'brak_klucza' => [
            'title' => 'Payment configuration',
            'p' => '<code style="background: #f1f5f9; padding: 0.1rem 0.35rem; border-radius: 0.25rem;">STRIPE_SECRET_KEY</code> is not set on the server, so the payment cannot be confirmed automatically. Contact your administrator or — if you are on the Free plan and signed in — use the upgrade page and the activation button (if still available).',
        ],
        'brak_sesji_stripe' => [
            'title' => 'Missing Stripe confirmation',
            'p' => 'The page URL should include a <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">session_id</code> parameter after redirecting from checkout. In Stripe (Payment Link → After payment), set the return URL with the <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">{CHECKOUT_SESSION_ID}</code> placeholder.',
        ],
        'blad_stripe' => [
            'title' => 'Stripe communication error',
            'p' => 'The checkout session could not be verified. Try again shortly or use the contact details on the site.',
        ],
        'nieoplacone' => [
            'title' => 'Payment not completed',
            'before' => 'The Stripe session is not paid. If you paid by card, check your email or try again from the ',
            'link' => 'upgrade',
            'after' => ' page.',
        ],
        'brak_powiazania' => [
            'title' => 'Not linked to an account',
            'before' => 'The payment does not include an account id (the Stripe link should be opened from the app via “Choose Full”). Go back to the ',
            'link' => 'upgrade page',
            'after' => ' and start checkout again.',
        ],
        'brak_uzytkownika' => [
            'title' => 'User not found',
            'p' => 'Contact support and include the payment date.',
        ],
        'default' => [
            'title' => 'Something went wrong',
            'p' => 'Please try again or contact support.',
        ],
        'home_link' => '← Home',
    ],
];
