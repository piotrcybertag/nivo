<?php

return [
    'upgrade_page_title' => 'Mise à niveau — Nivo',
    'upgrade_heading' => 'Passer au plan Full',
    'plan_full' => 'Plan Full',
    'price_line' => '3 € / mois',
    'paid_yearly' => 'Facturation annuelle (36 €).',
    'upgrade_description' => 'Employés illimités. Annuaire, organigramme et vue d\'ensemble complets — sans plafond à 10 personnes. Le paiement s\'ouvre dans le même onglet ; au retour de Stripe, le plan Full est activé et la session rétablie.',
    'upgrade_cta' => 'Choisir Full — payer avec Stripe',

    'success_return_page_title' => 'Paiement — plan Full — Nivo',
    'thanks_page_title' => 'Paiement terminé — Nivo',
    'thanks_heading' => 'Merci pour votre paiement',
    'thanks_accepted' => 'Nous avons bien reçu votre paiement pour le plan Full.',
    'thanks_click_activate' => 'Cliquez ci-dessous pour activer le plan Full sur votre compte :',
    'thanks_btn_activate' => 'Activer le plan Full',
    'thanks_full_active' => 'Votre plan Full est déjà actif.',
    'thanks_login_hint' => 'Connectez-vous à votre compte pour activer le plan Full (ou revenez plus tard — lien « Mise à niveau » du menu).',
    'back_home' => '← Retour à l\'accueil',

    'return' => [
        'sukces' => [
            'title' => 'Merci pour votre paiement',
            'p1' => 'Le plan Full est actif pour <strong>:name</strong>. Vous êtes reconnecté — vous pouvez utiliser l\'application sans limite d\'employés.',
            'p2' => 'La session a été rafraîchie ; inutile de vous reconnecter.',
            'cta' => 'Ouvrir l\'application',
        ],
        'brak_klucza' => [
            'title' => 'Configuration du paiement',
            'p' => '<code style="background: #f1f5f9; padding: 0.1rem 0.35rem; border-radius: 0.25rem;">STRIPE_SECRET_KEY</code> n\'est pas défini sur le serveur : le paiement ne peut pas être confirmé automatiquement. Contactez l\'administrateur ou — si vous êtes en plan gratuit et connecté — utilisez la page de mise à niveau et le bouton d\'activation (s\'il est encore disponible).',
        ],
        'brak_sesji_stripe' => [
            'title' => 'Confirmation Stripe manquante',
            'p' => 'L\'URL doit inclure le paramètre <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">session_id</code> après le paiement. Dans Stripe (Payment Link → After payment), définissez l\'URL de retour avec le marqueur <code style="background: #f1f5f9; padding: 0.1rem 0.35rem;">{CHECKOUT_SESSION_ID}</code>.',
        ],
        'blad_stripe' => [
            'title' => 'Erreur de communication avec Stripe',
            'p' => 'Impossible de vérifier la session de paiement. Réessayez plus tard ou utilisez les coordonnées du site.',
        ],
        'nieoplacone' => [
            'title' => 'Paiement incomplet',
            'before' => 'La session Stripe n\'est pas payée. Si vous avez payé par carte, vérifiez vos e-mails ou réessayez depuis la page ',
            'link' => 'mise à niveau',
            'after' => '.',
        ],
        'brak_powiazania' => [
            'title' => 'Absence de lien avec le compte',
            'before' => 'Le paiement ne contient pas d\'identifiant de compte (le lien Stripe doit être ouvert depuis l\'application via « Choisir Full »). Retournez à la ',
            'link' => 'page de mise à niveau',
            'after' => ' et relancez le paiement.',
        ],
        'brak_uzytkownika' => [
            'title' => 'Utilisateur introuvable',
            'p' => 'Contactez le support en indiquant la date du paiement.',
        ],
        'default' => [
            'title' => 'Un problème est survenu',
            'p' => 'Veuillez réessayer ou contacter le support.',
        ],
        'home_link' => '← Accueil',
    ],
];
