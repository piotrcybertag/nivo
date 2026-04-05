<?php

return [
    'upgrade_page_title' => 'Mejora — Nivo',
    'upgrade_heading' => 'Pasar al plan Full',
    'plan_full' => 'Plan Full',
    'price_line' => '3 € / mes',
    'paid_yearly' => 'Facturación anual (36 €).',
    'upgrade_description' => 'Sin límite de empleados. Directorio, organigrama y vista general completos — sin tope de 10 personas. El pago se abre en la misma pestaña; al volver de Stripe el plan Full queda activo y se restaura la sesión.',
    'upgrade_cta' => 'Elegir Full — pagar con Stripe',

    'success_return_page_title' => 'Pago — plan Full — Nivo',
    'thanks_page_title' => 'Pago completado — Nivo',
    'thanks_heading' => 'Gracias por su pago',
    'thanks_accepted' => 'Hemos recibido el pago del plan Full.',
    'thanks_click_activate' => 'Pulse abajo para activar el plan Full en su cuenta:',
    'thanks_btn_activate' => 'Activar plan Full',
    'thanks_full_active' => 'Su plan Full ya está activo.',
    'thanks_login_hint' => 'Inicie sesión en su cuenta para activar el plan Full (o vuelva más tarde — puede usar el enlace «Mejora» del menú).',
    'back_home' => '← Volver al inicio',

    'return' => [
        'sukces' => [
            'title' => 'Gracias por su pago',
            'p1' => 'El plan Full está activo para <strong>:name</strong>. Ha vuelto a iniciar sesión — puede usar la aplicación sin límite de empleados.',
            'p2' => 'La sesión se ha actualizado; no hace falta volver a entrar.',
            'cta' => 'Abrir la aplicación',
        ],
        'brak_klucza' => [
            'title' => 'Configuración de pagos',
            'p' => 'En el servidor no está definida <code style="background: #f1f5f9; padding: 0.1rem 0.35rem; border-radius: 0.25rem;">STRIPE_SECRET_KEY</code>, por lo que no se puede confirmar el pago automáticamente. Contacte al administrador o — si tiene plan gratuito y sesión iniciada — use la página de mejora y el botón de activación (si sigue disponible).',
        ],
        'brak_sesji_stripe' => [
            'title' => 'Falta confirmación de Stripe',
            'p' => 'La URL debe incluir el parámetro <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">session_id</code> tras el pago. En Stripe (Payment Link → After payment), configure la URL de retorno con el marcador <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">{CHECKOUT_SESSION_ID}</code>.',
        ],
        'blad_stripe' => [
            'title' => 'Error de comunicación con Stripe',
            'p' => 'No se pudo verificar la sesión de pago. Inténtelo más tarde o use los datos de contacto del sitio.',
        ],
        'nieoplacone' => [
            'title' => 'Pago no completado',
            'before' => 'La sesión de Stripe no está pagada. Si pagó con tarjeta, revise el correo o repita el proceso desde ',
            'link' => 'mejora',
            'after' => '.',
        ],
        'brak_powiazania' => [
            'title' => 'Sin vínculo a la cuenta',
            'before' => 'El pago no incluye el id de cuenta (el enlace de Stripe debe abrirse desde la app con «Elegir Full»). Vuelva a la ',
            'link' => 'página de mejora',
            'after' => ' e inicie el pago de nuevo.',
        ],
        'brak_uzytkownika' => [
            'title' => 'Usuario no encontrado',
            'p' => 'Contacte con soporte indicando la fecha del pago.',
        ],
        'default' => [
            'title' => 'Ha ocurrido un problema',
            'p' => 'Inténtelo de nuevo o contacte con soporte.',
        ],
        'home_link' => '← Inicio',
    ],
];
