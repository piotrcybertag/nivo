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
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">1. Data controller</h2>
                <p>The controller for this product site and contact form is the entity configured for the service (contact: <a href="mailto:{{ $adminEmail }}" class="text-indigo-600 hover:underline">{{ $adminEmail }}</a>), operating within the <strong>cyberrum</strong> ecosystem.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">2. Data we process</h2>
                <p><strong>Browsing:</strong> technical data (e.g. IP, logs) as needed for security and hosting, based on legitimate interest where applicable.</p>
                <p><strong>Contact form:</strong> name, email and message based on your consent and steps prior to a contract (Art. 6(1)(a)/(b) GDPR). We may send an automatic acknowledgement to your address.</p>
                <p><strong>Nivo account:</strong> account and organizational data you provide, including employee records you enter.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">3. Cookies</h2>
                <p>We use essential cookies (session, CSRF) and a consent cookie to remember your banner choice (default name may include “nivo”). You can control cookies in your browser.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">4. Recipients & retention</h2>
                <p>Processors such as hosting and email providers may access data as required. Contact form data is kept as long as needed to respond and comply with law.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">5. Your rights</h2>
                <p>You may have the right to access, rectify, erase, restrict, object, data portability and to lodge a complaint with your supervisory authority.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">6. Changes</h2>
                <p>We may update this policy; the current version stays on this page.</p>
            </section>
        </div>
    </div>
</section>
@endsection
