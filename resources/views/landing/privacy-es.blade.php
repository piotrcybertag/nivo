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
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">1. Responsable del tratamiento</h2>
                <p>El responsable de este sitio del producto y del formulario de contacto es la entidad configurada para el servicio (contacto: <a href="mailto:{{ $adminEmail }}" class="text-indigo-600 hover:underline">{{ $adminEmail }}</a>), dentro del ecosistema <strong>cyberrum</strong>.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">2. Datos que tratamos</h2>
                <p><strong>Navegación:</strong> datos técnicos (p. ej. IP, registros) según sea necesario por seguridad y alojamiento, sobre la base del interés legítimo cuando proceda.</p>
                <p><strong>Formulario de contacto:</strong> nombre, correo y mensaje sobre la base de su consentimiento y medidas precontractuales (art. 6(1)(a)/(b) RGPD). Podemos enviarle un acuse de recibo automático.</p>
                <p><strong>Cuenta Nivo:</strong> datos de cuenta y organizativos que facilite, incluidos los registros de empleados que introduzca.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">3. Cookies</h2>
                <p>Utilizamos cookies esenciales (sesión, CSRF) y una cookie de consentimiento para recordar su elección en el banner (el nombre por defecto puede incluir «nivo»). Puede gestionar las cookies en su navegador.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">4. Destinatarios y conservación</h2>
                <p>Encargados del tratamiento como alojamiento y correo pueden acceder a los datos cuando sea necesario. Los datos del formulario se conservan el tiempo imprescindible para responder y cumplir la ley.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">5. Sus derechos</h2>
                <p>Puede tener derecho de acceso, rectificación, supresión, limitación, oposición, portabilidad y a presentar reclamación ante la autoridad de control.</p>
            </section>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mt-0 mb-3">6. Cambios</h2>
                <p>Podemos actualizar esta política; la versión vigente permanecerá en esta página.</p>
            </section>
        </div>
    </div>
</section>
@endsection
