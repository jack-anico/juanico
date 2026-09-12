<?php

/**
 * Application Configuration
 *
 * Central app settings loaded from .env file.
 * Controls debug mode, environment, and base URL.
 */

// Load environment variables from .env file
$envPath = dirname(__DIR__) . '/.env';

if (!file_exists($envPath)) {
    throw new RuntimeException(
        '.env file not found. Copy .env.example to .env and fill in your values.'
    );
}

$envLines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($envLines as $line) {
    // Skip comment lines
    if (str_starts_with(trim($line), '#')) {
        continue;
    }

    // Parse KEY=VALUE pairs
    if (str_contains($line, '=')) {
        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value);

        // Don't overwrite existing environment variables
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key]            = $value;
            $_SERVER[$key]         = $value;
            putenv("{$key}={$value}");
        }
    }
}

/**
 * Helper function to retrieve environment variables with a fallback default.
 *
 * @param  string      $key     The environment variable name
 * @param  mixed       $default Fallback value if not set
 * @return string|null
 */
function env(string $key, mixed $default = null): mixed
{
    return $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key) ?: $default;
}

return [
    'env'   => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', 'false') === 'true',
    'url'   => env('APP_URL', 'http://localhost'),
];
