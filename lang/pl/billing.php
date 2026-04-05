<?php

return [
    'upgrade_page_title' => 'Upgrade — Nivo',
    'upgrade_heading' => 'Przejdź na plan Full',
    'plan_full' => 'Plan Full',
    'price_line' => '3 € / miesiąc',
    'paid_yearly' => 'Płatne rocznie (36 €).',
    'upgrade_description' => 'Bez limitu pracowników. Pełna kartoteka, schemat i przegląd — bez ograniczenia do 10 osób. Płatność otwiera się w tej samej karcie; po powrocie z Stripe plan Full zostanie aktywowany, a sesja logowania przywrócona.',
    'upgrade_cta' => 'Wybierz Full — płatność Stripe',

    'success_return_page_title' => 'Płatność — plan Full — Nivo',
    'thanks_page_title' => 'Płatność zakończona — Nivo',
    'thanks_heading' => 'Dziękujemy za płatność',
    'thanks_accepted' => 'Płatność za plan Full została przyjęta.',
    'thanks_click_activate' => 'Kliknij poniżej, aby włączyć plan Full w swoim koncie:',
    'thanks_btn_activate' => 'Aktywuj plan Full',
    'thanks_full_active' => 'Twój plan Full jest już aktywny.',
    'thanks_login_hint' => 'Zaloguj się na swoje konto, aby aktywować plan Full (lub wróć później — możesz wtedy wejść w link „Upgrade” w menu).',
    'back_home' => '← Wróć do strony głównej',

    'return' => [
        'sukces' => [
            'title' => 'Dziękujemy za płatność',
            'p1' => 'Plan Full został aktywowany na koncie <strong>:name</strong>. Jesteś z powrotem zalogowany — możesz korzystać z aplikacji bez limitu pracowników.',
            'p2' => 'Sesja została odświeżona; nie musisz logować się ponownie.',
            'cta' => 'Przejdź do aplikacji',
        ],
        'brak_klucza' => [
            'title' => 'Konfiguracja płatności',
            'p' => 'Na serwerze nie ustawiono <code style="background: #f1f5f9; padding: 0.1rem 0.35rem; border-radius: 0.25rem;">STRIPE_SECRET_KEY</code>, więc nie można potwierdzić płatności automatycznie. Skontaktuj się z administratorem lub — jeśli jesteś zalogowany na planie Free — użyj strony upgrade i przycisku aktywacji (jeśli nadal jest dostępny).',
        ],
        'brak_sesji_stripe' => [
            'title' => 'Brak potwierdzenia z Stripe',
            'p' => 'W adresie strony powinien znaleźć się parametr <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">session_id</code> po przekierowaniu z płatności. Upewnij się, że w Stripe (Payment Link → After payment) ustawiono adres powrotu z placeholderem <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">{CHECKOUT_SESSION_ID}</code>.',
        ],
        'blad_stripe' => [
            'title' => 'Komunikacja ze Stripe',
            'p' => 'Nie udało się zweryfikować sesji płatności. Spróbuj ponownie za chwilę lub napisz na kontakt podany na stronie.',
        ],
        'nieoplacone' => [
            'title' => 'Płatność niedokończona',
            'before' => 'Sesja Stripe nie ma statusu opłaconej płatności. Jeśli płaciłeś kartą, sprawdź skrzynkę e-mail lub ponów płatność z poziomu ',
            'link' => 'upgrade',
            'after' => '.',
        ],
        'brak_powiazania' => [
            'title' => 'Brak powiązania z kontem',
            'before' => 'Płatność nie zawiera identyfikatora konta (link do Stripe powinien być otwarty z aplikacji przez „Wybierz Full”). Wróć do ',
            'link' => 'strony upgrade',
            'after' => ' i rozpocznij płatność ponownie.',
        ],
        'brak_uzytkownika' => [
            'title' => 'Nie znaleziono użytkownika',
            'p' => 'Skontaktuj się z pomocą techniczną podając datę płatności.',
        ],
        'default' => [
            'title' => 'Wystąpił problem',
            'p' => 'Spróbuj ponownie lub skontaktuj się z pomocą.',
        ],
        'home_link' => '← Strona główna',
    ],
];
