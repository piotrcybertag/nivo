<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

define('LARAVEL_START', microtime(true));

header('Content-Type: text/html; charset=utf-8');
header('X-Robots-Tag: noindex, nofollow');

set_time_limit(300);

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

try {
    $code = Artisan::call('migrate', ['--force' => true]);
    $out = Artisan::output();
    echo '<pre>'.htmlspecialchars($out, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').'</pre>';
    if ($code !== 0) {
        http_response_code(500);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo '<pre>'.htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').'</pre>';
}
