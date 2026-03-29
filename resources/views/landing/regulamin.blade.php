@extends('landing.layout')

@section('title', __('landing.legal.terms_title_suffix'))
@section('meta_description', __('landing.meta.description_terms'))

@section('content')
<section class="bg-white border-b border-gray-200">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-12 lg:py-16">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-2">{{ __('landing.legal.terms_h1') }}</h1>
        <p class="text-sm text-gray-500 mb-10">{{ __('landing.legal.terms_lead', ['product' => 'Nivo']) }}</p>
        @php
            $adminEmail = config('nivo_landing.contact_admin_email');
        @endphp
        <div class="max-w-none text-gray-700 space-y-8 text-[15px] leading-relaxed">
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">1. Postanowienia ogólne</h2>
                <ol class="list-decimal pl-5 space-y-2">
                    <li>Niniejszy regulamin określa zasady korzystania ze strony prezentującej produkt <strong>Nivo</strong> oraz z funkcji udostępnianych po zalogowaniu w aplikacji Nivo.</li>
                    <li>Usługodawcą jest podmiot obsługujący serwis pod adresem nivo.cyberrum.eu, kontakt: <a href="mailto:{{ $adminEmail }}" class="text-indigo-600 hover:underline">{{ $adminEmail }}</a>.</li>
                    <li>Korzystanie ze strony informacyjnej oznacza akceptację postanowień dotyczących przeglądania treści. Utworzenie konta może wymagać osobnej akceptacji w procesie rejestracji.</li>
                </ol>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">2. Usługa</h2>
                <p>Nivo służy do prowadzenia kartoteki pracowników, relacji przełożonych (linia i matrix) oraz wizualizacji struktury organizacyjnej (schemat, przegląd) w przeglądarce. Zakres funkcji zależy od planu (np. Free / Full) i konfiguracji.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">3. Konto i bezpieczeństwo</h2>
                <p>Użytkownik zobowiązany jest do podawania prawidłowych danych przy rejestracji oraz do zachowania poufności hasła i linków dostępowych. Działania wykonane po zalogowaniu są przypisywane do konta, chyba że udowodnione złamanie zabezpieczeń z winy usługodawcy.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">4. Dopuszczalne użycie</h2>
                <p>Zabronione jest wykorzystywanie serwisu w sposób bezprawny, zakłócający działanie infrastruktury lub naruszający prawa osób trzecich. Klient odpowiada za dane pracowników i struktury wprowadzane do systemu.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">5. Odpowiedzialność</h2>
                <p>Usługodawca dokłada starań, aby usługa była dostępna, jednak nie gwarantuje nieprzerwanego działania. Odpowiedzialność ogranicza się do wymogu prawa i niniejszego regulaminu.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">6. Zmiany</h2>
                <p>Regulamin może zostać zmieniony; kontynuowanie korzystania po publikacji zmian może wymagać ponownej akceptacji, jeśli wprowadzono taki mechanizm.</p>
            </section>
        </div>
    </div>
</section>
@endsection
