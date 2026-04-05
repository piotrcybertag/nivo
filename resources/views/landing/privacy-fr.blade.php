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
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">1. Responsable du traitement</h2>
                <p>Le responsable de ce site produit et du formulaire de contact est l’entité configurée pour le service (contact : <a href="mailto:{{ $adminEmail }}" class="text-indigo-600 hover:underline">{{ $adminEmail }}</a>), au sein de l’écosystème <strong>cyberrum</strong>.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">2. Données traitées</h2>
                <p><strong>Navigation :</strong> données techniques (ex. adresse IP, journaux) selon les besoins de sécurité et d’hébergement, sur la base de l’intérêt légitime le cas échéant.</p>
                <p><strong>Formulaire de contact :</strong> nom, e-mail et message sur la base de votre consentement et des mesures précontractuelles (art. 6(1)(a)/(b) RGPD). Un accusé de réception automatique peut être envoyé à votre adresse.</p>
                <p><strong>Compte Nivo :</strong> données de compte et organisationnelles que vous fournissez, y compris les fiches employés que vous saisissez.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">3. Cookies</h2>
                <p>Nous utilisons des cookies essentiels (session, CSRF) et un cookie de consentement pour mémoriser votre choix sur la bannière (le nom par défaut peut inclure « nivo »). Vous pouvez gérer les cookies dans votre navigateur.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">4. Destinataires et conservation</h2>
                <p>Des sous-traitants tels que l’hébergeur et les prestataires de messagerie peuvent accéder aux données si nécessaire. Les données du formulaire de contact sont conservées le temps nécessaire pour répondre et respecter la loi.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">5. Vos droits</h2>
                <p>Vous pouvez disposer d’un droit d’accès, de rectification, d’effacement, de limitation, d’opposition, à la portabilité et d’introduire une réclamation auprès de l’autorité de contrôle compétente.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">6. Modifications</h2>
                <p>Nous pouvons mettre à jour cette politique ; la version en vigueur reste sur cette page.</p>
            </section>
        </div>
    </div>
</section>
@endsection
