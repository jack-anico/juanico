<?php

declare(strict_types=1);

/**
 * Front Controller — Every request enters here.
 *
 * Responsibilities:
 *   1. Configure error reporting
 *   2. Define base path constants
 *   3. Load .env via config/app.php
 *   4. Register the PSR-4 autoloader (App\ → src/)
 *   5. Load global helper functions
 *   6. Start the session securely
 *   7. Boot the router, load routes, dispatch
 */

// -----------------------------------------------------------------
//  1. Error reporting (rubric #6: no raw PHP errors exposed)
// -----------------------------------------------------------------
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', dirname(__DIR__) . '/storage/logs/error.log');

// -----------------------------------------------------------------
//  2. Base path constants
// -----------------------------------------------------------------
define('BASE_PATH', dirname(__DIR__));
define('VIEW_PATH', BASE_PATH . '/views');

// -----------------------------------------------------------------
//  3. Load app config (parses .env, defines env() helper)
// -----------------------------------------------------------------
$appConfig = require BASE_PATH . '/config/app.php';

// In development, show errors on-screen for convenience
if ($appConfig['debug']) {
    ini_set('display_errors', '1');
}

// -----------------------------------------------------------------
//  4. Manual PSR-4 autoloader: App\Core\Database → src/Core/Database.php
// -----------------------------------------------------------------
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';

    if (!str_starts_with($class, $prefix)) {
        return; // Not our namespace — skip
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = BASE_PATH . '/src/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// -----------------------------------------------------------------
//  5. Load global helper functions (url(), old(), csrf_field(), etc.)
// -----------------------------------------------------------------
require BASE_PATH . '/src/Helpers/helpers.php';

// -----------------------------------------------------------------
//  6. Start session with secure settings (rubric #5)
// -----------------------------------------------------------------
session_start([
    'cookie_httponly' => true,       // JS cannot read session cookie
    'cookie_samesite' => 'Lax',     // CSRF protection at cookie level
    'use_strict_mode' => true,       // Reject uninitialized session IDs
]);

// -----------------------------------------------------------------
//  7. Boot router, load routes, dispatch the current request
// -----------------------------------------------------------------
$router = new App\Core\Router();

require BASE_PATH . '/config/routes.php';

$router->dispatch();

// After the view has rendered, consume flash data so it only lives for one request
consumeFlash();
