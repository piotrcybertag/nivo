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
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">1. General</h2>
                <p>These terms govern use of the website and the logged-in <strong>Nivo</strong> service (employee directory and organizational charts) at nivo.cyberrum.eu. Support: <a href="mailto:{{ $adminEmail }}" class="text-indigo-600 hover:underline">{{ $adminEmail }}</a>.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">2. The service</h2>
                <p>Nivo provides tools to manage people records, reporting lines (line/matrix) and visualize structure (tree, overview). Features depend on your plan and configuration.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">3. Accounts</h2>
                <p>You must provide accurate registration data and keep credentials confidential. Actions taken while logged in are attributed to your account except where security failure is proven not your fault.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">4. Acceptable use</h2>
                <p>No unlawful use, no attempts to disrupt the platform or bypass security. You are responsible for employee data you import.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">5. Liability</h2>
                <p>We strive for availability but do not guarantee uninterrupted service. Liability is limited as permitted by law and these terms.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">6. Changes</h2>
                <p>We may update these terms; continued use may require acceptance if we add such a step.</p>
            </section>
        </div>
    </div>
</section>
@endsection
