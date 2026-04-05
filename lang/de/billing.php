<?php

return [
    'upgrade_page_title' => 'Upgrade — Nivo',
    'upgrade_heading' => 'Upgrade auf den Full-Tarif',
    'plan_full' => 'Full-Tarif',
    'price_line' => '3 € / Monat',
    'paid_yearly' => 'Jährliche Abrechnung (36 €).',
    'upgrade_description' => 'Unbegrenzte Mitarbeitende. Volles Verzeichnis, Organigramm und Übersicht — ohne 10-Personen-Limit. Checkout im gleichen Tab; nach Rückkehr von Stripe ist Full aktiv und Ihre Sitzung bleibt erhalten.',
    'upgrade_cta' => 'Full wählen — mit Stripe zahlen',

    'success_return_page_title' => 'Zahlung — Full-Tarif — Nivo',
    'thanks_page_title' => 'Zahlung abgeschlossen — Nivo',
    'thanks_heading' => 'Vielen Dank für Ihre Zahlung',
    'thanks_accepted' => 'Ihre Zahlung für Full ist eingegangen.',
    'thanks_click_activate' => 'Klicken Sie unten, um Full für Ihr Konto zu aktivieren:',
    'thanks_btn_activate' => 'Full aktivieren',
    'thanks_full_active' => 'Full ist bereits aktiv.',
    'thanks_login_hint' => 'Melden Sie sich an, um Full zu aktivieren (oder kommen Sie später wieder — Menüpunkt „Upgrade“).',
    'back_home' => '← Zur Startseite',

    'return' => [
        'sukces' => [
            'title' => 'Vielen Dank für Ihre Zahlung',
            'p1' => 'Der Full-Tarif ist jetzt aktiv für <strong>:name</strong>. Sie sind wieder angemeldet — Sie können die App ohne Mitarbeiterlimit nutzen.',
            'p2' => 'Ihre Sitzung wurde aktualisiert; erneute Anmeldung ist nicht nötig.',
            'cta' => 'App öffnen',
        ],
        'brak_klucza' => [
            'title' => 'Zahlungskonfiguration',
            'p' => '<code style="background: #f1f5f9; padding: 0.1rem 0.35rem; border-radius: 0.25rem;">STRIPE_SECRET_KEY</code> ist auf dem Server nicht gesetzt, daher kann die Zahlung nicht automatisch bestätigt werden. Wenden Sie sich an den Administrator oder — wenn Sie im Free-Tarif angemeldet sind — nutzen Sie die Upgrade-Seite und ggf. den Aktivierungsbutton.',
        ],
        'brak_sesji_stripe' => [
            'title' => 'Stripe-Bestätigung fehlt',
            'p' => 'Die Seiten-URL sollte nach dem Checkout den Parameter <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">session_id</code> enthalten. In Stripe (Payment Link → After payment) die Rückkehr-URL mit Platzhalter <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">{CHECKOUT_SESSION_ID}</code> setzen.',
        ],
        'blad_stripe' => [
            'title' => 'Stripe-Kommunikationsfehler',
            'p' => 'Die Checkout-Sitzung konnte nicht verifiziert werden. Versuchen Sie es später erneut oder nutzen Sie die Kontaktdaten auf der Website.',
        ],
        'nieoplacone' => [
            'title' => 'Zahlung nicht abgeschlossen',
            'before' => 'Die Stripe-Sitzung ist nicht bezahlt. Bei Kartenzahlung prüfen Sie Ihre E-Mails oder versuchen Sie es erneut über die ',
            'link' => 'Upgrade',
            'after' => '-Seite.',
        ],
        'brak_powiazania' => [
            'title' => 'Keine Kontoverknüpfung',
            'before' => 'Der Zahlung fehlt die Konto-ID (Stripe-Link muss über die App mit „Full wählen“ geöffnet werden). Zurück zur ',
            'link' => 'Upgrade-Seite',
            'after' => ' und Checkout erneut starten.',
        ],
        'brak_uzytkownika' => [
            'title' => 'Benutzer nicht gefunden',
            'p' => 'Wenden Sie sich an den Support mit dem Zahlungsdatum.',
        ],
        'default' => [
            'title' => 'Etwas ist schiefgelaufen',
            'p' => 'Bitte erneut versuchen oder Support kontaktieren.',
        ],
        'home_link' => '← Start',
    ],
];
