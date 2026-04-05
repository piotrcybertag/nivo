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
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">1. Généralités</h2>
                <p>Ces conditions régissent l’utilisation du site et du service connecté <strong>Nivo</strong> (annuaire des employés et organigrammes) sur nivo.cyberrum.eu. Support : <a href="mailto:{{ $adminEmail }}" class="text-indigo-600 hover:underline">{{ $adminEmail }}</a>.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">2. Le service</h2>
                <p>Nivo fournit des outils pour gérer les fiches personnes, les lignes hiérarchiques (ligne/matrice) et visualiser la structure (arbre, vue d’ensemble). Les fonctionnalités dépendent de votre offre et de la configuration.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">3. Comptes</h2>
                <p>Vous devez fournir des données d’inscription exactes et garder vos identifiants confidentiels. Les actions effectuées après connexion sont imputées à votre compte, sauf preuve d’une défaillance de sécurité indépendante de votre faute.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">4. Usage acceptable</h2>
                <p>Pas d’usage illicite, pas de tentative de perturber la plateforme ou de contourner la sécurité. Vous êtes responsable des données employés que vous importez.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">5. Responsabilité</h2>
                <p>Nous visons une bonne disponibilité mais ne garantissons pas un service ininterrompu. La responsabilité est limitée dans la mesure permise par la loi et par les présentes conditions.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">6. Modifications</h2>
                <p>Nous pouvons mettre à jour ces conditions ; l’utilisation continue peut nécessiter une nouvelle acceptation si nous ajoutons une étape de ce type.</p>
            </section>
        </div>
    </div>
</section>
@endsection
