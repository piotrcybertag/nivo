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
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">1. Allgemeines</h2>
                <p>Diese Bedingungen regeln die Nutzung der Website und des angemeldeten Dienstes <strong>Nivo</strong> (Mitarbeiterverzeichnis und Organigramme) unter nivo.cyberrum.eu. Support: <a href="mailto:{{ $adminEmail }}" class="text-indigo-600 hover:underline">{{ $adminEmail }}</a>.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">2. Der Dienst</h2>
                <p>Nivo bietet Werkzeuge zur Pflege von Personendaten, Berichtslinien (Linie/Matrix) und zur Visualisierung der Struktur (Baum, Übersicht). Der Funktionsumfang hängt von Tarif und Konfiguration ab.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">3. Konten</h2>
                <p>Sie müssen korrekte Registrierungsdaten angeben und Zugangsdaten geheim halten. Handlungen nach Anmeldung werden Ihrem Konto zugerechnet, sofern kein Sicherheitsversagen ohne Ihr Verschulden nachgewiesen wird.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">4. Zulässige Nutzung</h2>
                <p>Keine rechtswidrige Nutzung, keine Störung der Plattform oder Umgehung der Sicherheit. Sie sind für importierte Mitarbeitendendaten verantwortlich.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">5. Haftung</h2>
                <p>Wir streben hohe Verfügbarkeit an, garantieren aber keinen unterbrechungsfreien Betrieb. Die Haftung ist im gesetzlich zulässigen Rahmen und nach diesen Bedingungen begrenzt.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">6. Änderungen</h2>
                <p>Wir können diese Bedingungen aktualisieren; die weitere Nutzung kann eine erneute Zustimmung erfordern, falls wir einen solchen Schritt einführen.</p>
            </section>
        </div>
    </div>
</section>
@endsection
