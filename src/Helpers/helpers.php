<?php

declare(strict_types=1);

/**
 * Global Helper Functions
 *
 * Loaded in public/index.php before routing.
 * Available everywhere in the application (controllers, views, etc.).
 */

// -----------------------------------------------------------------
//  URL Helpers
// -----------------------------------------------------------------

/**
 * Generate a full URL path relative to the app's base directory.
 * Handles subdirectory installations (e.g. /WEB/public/).
 *
 * Example: url('/register') → '/WEB/public/register'
 */
function url(string $path = '/'): string
{
    static $base = null;

    if ($base === null) {
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    return $base . '/' . ltrim($path, '/');
}

// -----------------------------------------------------------------
//  Flash Message Helpers (for validation errors & old input)
// -----------------------------------------------------------------

/**
 * Store a value in flash session (survives exactly one more request).
 */
function flash(string $key, mixed $value): void
{
    $_SESSION['_flash'][$key] = $value;
}

/**
 * Get validation errors from flash session.
 * Pass a key to get a specific field's error, or null for all errors.
 *
 * @param  string|null $key Field name
 * @return array|string     All errors (array) or single error (string)
 */
function errors(?string $key = null): array|string
{
    $allErrors = $_SESSION['_flash']['errors'] ?? [];

    if ($key !== null) {
        return $allErrors[$key] ?? '';
    }

    return $allErrors;
}

/**
 * Check if a specific field has a validation error.
 */
function hasError(string $key): bool
{
    return !empty($_SESSION['_flash']['errors'][$key]);
}

/**
 * Get old form input from flash session (repopulate forms after errors).
 * Output is automatically HTML-escaped to prevent XSS.
 */
function old(string $key, string $default = ''): string
{
    return htmlspecialchars(
        $_SESSION['_flash']['old'][$key] ?? $default,
        ENT_QUOTES,
        'UTF-8'
    );
}

/**
 * Consume (clear) all flash data. Called at the end of each request
 * in public/index.php so flash lives for exactly one redirect.
 */
function consumeFlash(): void
{
    unset($_SESSION['_flash']);
}

// -----------------------------------------------------------------
//  CSRF Protection
// -----------------------------------------------------------------

/**
 * Generate a hidden HTML input field containing the CSRF token.
 * Use inside <form> tags.
 */
function csrf_field(): string
{
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }

    return '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars($_SESSION['_csrf_token'], ENT_QUOTES, 'UTF-8')
        . '">';
}

// -----------------------------------------------------------------
//  Auth Helpers
// -----------------------------------------------------------------

/**
 * Check if the current user is logged in.
 */
function isAuthenticated(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * Get the authenticated user's ID, or null if not logged in.
 */
function authUserId(): ?int
{
    return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
}

// -----------------------------------------------------------------
//  Output Helpers
// -----------------------------------------------------------------

/**
 * Escape a string for safe HTML output (prevents XSS).
 * Shorthand for htmlspecialchars().
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
