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
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">1. Verantwortlicher</h2>
                <p>Verantwortlich für diese Produktseite und das Kontaktformular ist die für den Dienst konfigurierte Stelle (Kontakt: <a href="mailto:{{ $adminEmail }}" class="text-indigo-600 hover:underline">{{ $adminEmail }}</a>) im Ökosystem <strong>cyberrum</strong>.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">2. Verarbeitete Daten</h2>
                <p><strong>Browsing:</strong> technische Daten (z. B. IP, Logs) soweit für Sicherheit und Hosting erforderlich, ggf. auf Grundlage berechtigten Interesses.</p>
                <p><strong>Kontaktformular:</strong> Name, E-Mail und Nachricht auf Grundlage Ihrer Einwilligung und vorvertraglicher Maßnahmen (Art. 6 Abs. 1 lit. a/b DSGVO). Eine automatische Bestätigung kann an Ihre Adresse gesendet werden.</p>
                <p><strong>Nivo-Konto:</strong> Konten- und organisationsbezogene Daten sowie von Ihnen eingegebene Mitarbeiterdaten.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">3. Cookies</h2>
                <p>Wir setzen notwendige Cookies (Session, CSRF) und ein Einwilligungs-Cookie für Ihre Banner-Wahl (der Standardname kann „nivo“ enthalten). Sie können Cookies im Browser steuern.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">4. Empfänger und Speicherfrist</h2>
                <p>Auftragsverarbeiter wie Hosting- und E-Mail-Anbieter können bei Bedarf Zugriff haben. Kontaktformular-Daten speichern wir so lange wie zur Beantwortung und zur Erfüllung gesetzlicher Pflichten nötig.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">5. Ihre Rechte</h2>
                <p>Sie haben ggf. Recht auf Auskunft, Berichtigung, Löschung, Einschränkung, Widerspruch, Datenportabilität und Beschwerde bei einer Aufsichtsbehörde.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">6. Änderungen</h2>
                <p>Wir können diese Erklärung anpassen; die aktuelle Fassung bleibt auf dieser Seite.</p>
            </section>
        </div>
    </div>
</section>
@endsection
