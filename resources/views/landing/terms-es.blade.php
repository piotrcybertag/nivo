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
                <p>Estos términos rigen el uso del sitio web y del servicio registrado <strong>Nivo</strong> (directorio de empleados y organigramas) en nivo.cyberrum.eu. Soporte: <a href="mailto:{{ $adminEmail }}" class="text-indigo-600 hover:underline">{{ $adminEmail }}</a>.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">2. El servicio</h2>
                <p>Nivo ofrece herramientas para gestionar fichas de personas, líneas de informe (línea/matriz) y visualizar la estructura (árbol, vista general). Las funciones dependen de su plan y de la configuración.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">3. Cuentas</h2>
                <p>Debe facilitar datos de registro veraces y mantener la confidencialidad de las credenciales. Las acciones realizadas con sesión iniciada se atribuyen a su cuenta salvo que se demuestre un fallo de seguridad ajeno a usted.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">4. Uso aceptable</h2>
                <p>Prohibido el uso ilícito, intentos de perturbar la plataforma o eludir la seguridad. Usted es responsable de los datos de empleados que importe.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">5. Responsabilidad</h2>
                <p>Buscamos la disponibilidad del servicio pero no garantizamos un funcionamiento ininterrumpido. La responsabilidad queda limitada en la medida permitida por la ley y estos términos.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">6. Cambios</h2>
                <p>Podemos actualizar estos términos; el uso continuado puede requerir aceptación si añadimos dicho paso.</p>
            </section>
        </div>
    </div>
</section>
@endsection
