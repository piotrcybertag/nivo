@extends('landing.layout')

@section('title', __('landing.legal.privacy_title_suffix'))
@section('meta_description', __('landing.meta.description_privacy'))

@section('content')
<section class="bg-white border-b border-gray-200">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-12 lg:py-16">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-2">{{ __('landing.legal.privacy_h1') }}</h1>
        <p class="text-sm text-gray-500 mb-10">{{ __('landing.legal.privacy_lead', ['product' => 'Nivo']) }}</p>
        @php
            $adminEmail = config('nivo_landing.contact_admin_email');
        @endphp
        <div class="max-w-none text-gray-700 space-y-8 text-[15px] leading-relaxed">
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">1. Administrator danych</h2>
                <p class="mb-0">Administratorem danych w zakresie strony produktu Nivo i formularza kontaktowego jest podmiot wskazany przy konfiguracji serwisu (kontakt: <a href="mailto:{{ $adminEmail }}" class="text-indigo-600 hover:underline">{{ $adminEmail }}</a>), działający w ramach ekosystemu <strong>cyberrum</strong>.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">2. Jakie dane przetwarzamy i po co</h2>
                <h3 class="text-base font-semibold text-gray-900 mt-4 mb-2">2.1. Przeglądanie strony</h3>
                <p>Przy korzystaniu ze strony mogą być przetwarzane dane techniczne (np. adres IP, data i czas żądania, informacje o przeglądarce) — w zakresie niezbędnym do działania i bezpieczeństwa serwisu, na podstawie prawnie uzasadnionego interesu administratora (art. 6 ust. 1 lit. f RODO).</p>
                <h3 class="text-base font-semibold text-gray-900 mt-4 mb-2">2.2. Formularz kontaktowy</h3>
                <p>Jeśli wyślesz wiadomość przez formularz, przetwarzamy: imię i nazwisko (lub nazwa), adres e-mail oraz treść wiadomości. Podstawą jest Twoja zgoda (art. 6 ust. 1 lit. a RODO) oraz — w zakresie niezbędnym do odpowiedzi — podjęcie działań na Twoje żądanie (art. 6 ust. 1 lit. b RODO).</p>
                <p class="mb-0">Dane przekazujemy pocztą elektroniczną na adres obsługi kontaktu. Na Twój e-mail może zostać wysłane automatyczne potwierdzenie (bez ujawniania skrzynki docelowej administratora w treści tego maila).</p>
                <h3 class="text-base font-semibold text-gray-900 mt-4 mb-2">2.3. Konto w aplikacji Nivo</h3>
                <p>Założenie konta i korzystanie z aplikacji wiąże się z przetwarzaniem danych niezbędnych do świadczenia usługi (m.in. dane konta, dane pracowników wprowadzane przez klienta). Szczegóły wynikają z niniejszej polityki, regulaminu oraz ustawień konta.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">3. Pliki cookie</h2>
                <p>Stosujemy m.in.:</p>
                <ul class="list-disc pl-5 space-y-2 mt-2">
                    <li><strong>Niezbędne</strong> — sesja, CSRF, działanie formularzy.</li>
                    <li><strong>Zgoda (baner)</strong> — zapamiętanie wyboru dotyczącego plików cookie (nazwa cookie zależy od konfiguracji, domyślnie prefiks związany z „nivo”).</li>
                </ul>
                <p class="mt-3">Możesz zarządzać plikami cookie w przeglądarce. Ograniczenie plików niezbędnych może utrudnić korzystanie z serwisu.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">4. Odbiorcy i okres przechowywania</h2>
                <p>Dane mogą być powierzane podmiotom hostingu, IT i poczty — w zakresie niezbędnym. Dane z formularza przechowujemy przez czas potrzebny do odpowiedzi i ewentualnej korespondencji, a następnie zgodnie z prawem lub do skutecznego sprzeciwu / usunięcia, jeśli podstawą była zgoda.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">5. Twoje prawa</h2>
                <p>Przysługują Ci m.in. dostęp, sprostowanie, usunięcie lub ograniczenie przetwarzania, sprzeciw, przenoszenie danych (gdy ma zastosowanie), cofnięcie zgody w dowolnym momencie. Skargę możesz złożyć do Prezesa PUODO.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">6. Zmiany</h2>
                <p>Politykę możemy zaktualizować; aktualna wersja będzie pod tym adresem.</p>
            </section>
        </div>
    </div>
</section>
@endsection
