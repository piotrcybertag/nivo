<?php

namespace App\Support;

use App\Models\Uzytkownik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Audit trail (nawigacja landing, rejestracja, logowanie, Stripe Full). Geolokalizacja IP przez HTTP ip-api.com.
 * Kanał `admin` (config/logging.php) — driver daily → pliki storage/logs/admin-YYYY-MM-DD.log.
 */
final class AdminLog
{
    public static function landingNavigation(Request $request): void
    {
        $route = $request->route()?->getName() ?? '-';
        $route = preg_replace('/[^\w.\-]/', '', (string) $route) ?: '-';
        $path = str_replace(["\n", "\r"], '', '/'.$request->path());
        $path = $path === '//' ? '/' : $path;
        $ip = $request->ip() ?? 'unknown';
        Log::channel('admin')->info(sprintf(
            'landing_nav route=%s path=%s ip=%s %s',
            $route,
            $path,
            $ip,
            self::geoSuffix($ip)
        ));
    }

    public static function registrationPageOpen(Request $request): void
    {
        $route = $request->route()?->getName() ?? 'rejestracja';
        $path = str_replace(["\n", "\r"], '', '/'.$request->path());
        $ip = $request->ip() ?? 'unknown';
        Log::channel('admin')->info(sprintf(
            'registration_page_open route=%s path=%s ip=%s %s',
            $route,
            $path,
            $ip,
            self::geoSuffix($ip)
        ));
    }

    public static function userRegistered(string $imieNazwisko, string $plan): void
    {
        Log::channel('admin')->info(sprintf(
            'registration user=%s plan=%s',
            self::quotify($imieNazwisko),
            strtoupper($plan)
        ));
    }

    public static function userLogin(string $imieNazwisko): void
    {
        Log::channel('admin')->info(sprintf(
            'login user=%s',
            self::quotify($imieNazwisko)
        ));
    }

    /** Użytkownik przekierowany do Stripe Payment Link (plan Full). */
    public static function stripeCheckoutStarted(Request $request, Uzytkownik $uzytkownik): void
    {
        if (! config('admin_audit.enabled', true)) {
            return;
        }
        $ip = $request->ip() ?? 'unknown';
        Log::channel('admin')->info(sprintf(
            'stripe_checkout_start user_id=%d user=%s ip=%s %s',
            $uzytkownik->id,
            self::quotify((string) $uzytkownik->imie_nazwisko),
            $ip,
            self::geoSuffix($ip)
        ));
    }

    /** Stripe potwierdził opłaconą sesję checkout; konto przełączone / zweryfikowane jako Full. */
    public static function stripePaymentCompleted(Request $request, Uzytkownik $uzytkownik, string $sessionId): void
    {
        if (! config('admin_audit.enabled', true)) {
            return;
        }
        $sessionId = preg_replace('/[^a-zA-Z0-9_]/', '', $sessionId) ?: '-';
        $ip = $request->ip() ?? 'unknown';
        Log::channel('admin')->info(sprintf(
            'stripe_payment_paid user_id=%d user=%s session_id=%s ip=%s %s',
            $uzytkownik->id,
            self::quotify((string) $uzytkownik->imie_nazwisko),
            $sessionId,
            $ip,
            self::geoSuffix($ip)
        ));
    }

    private static function geoSuffix(string $ip): string
    {
        if ($ip === 'unknown' || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return '(lokalnie / sieć prywatna)';
        }

        $label = Cache::remember('admin_geo_'.hash('sha256', $ip), 86400, fn () => self::fetchGeoLabel($ip));

        return $label ?? '(geolokalizacja niedostępna)';
    }

    private static function fetchGeoLabel(string $ip): ?string
    {
        try {
            $url = sprintf('http://ip-api.com/json/%s?fields=status,country,city', rawurlencode($ip));
            $res = Http::timeout(1.5)->connectTimeout(1)->get($url);
            if (! $res->ok()) {
                return null;
            }
            $data = $res->json();
            if (($data['status'] ?? '') !== 'success') {
                return null;
            }
            $country = trim((string) ($data['country'] ?? ''));
            $city = trim((string) ($data['city'] ?? ''));
            if ($country === '' && $city === '') {
                return '(?, ?)';
            }
            if ($city === '') {
                return '('.$country.', ?)';
            }
            if ($country === '') {
                return '(?, '.$city.')';
            }

            return '('.$country.', '.$city.')';
        } catch (\Throwable) {
            return null;
        }
    }

    private static function quotify(string $s): string
    {
        $s = str_replace(['"', "\n", "\r"], ['', ' ', ' '], $s);

        return '"'.$s.'"';
    }
}
