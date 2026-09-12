<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Response — Helpers for sending HTTP responses.
 *
 * Supports JSON responses, redirects, and view rendering.
 */
class Response
{
    /**
     * Send a JSON response and terminate.
     *
     * @param  mixed $data   Data to encode as JSON
     * @param  int   $status HTTP status code
     */
    public function json(mixed $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Redirect to another URL and terminate.
     *
     * @param  string $url    Target URL
     * @param  int    $status HTTP status code (302 = temporary, 301 = permanent)
     */
    public function redirect(string $url, int $status = 302): never
    {
        http_response_code($status);
        header('Location: ' . $url);
        exit;
    }

    /**
     * Render a PHP view template.
     *
     * View paths use dot notation:
     *   'auth.register' → views/auth/register.php
     *   'home.index'    → views/home/index.php
     *
     * @param  string $view Dot-notated view path
     * @param  array  $data Variables to make available in the view
     */
    public function view(string $view, array $data = []): void
    {
        $file = VIEW_PATH . '/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($file)) {
            throw new \RuntimeException("View not found: {$view} ({$file})");
        }

        // Extract data array as local variables for the view
        extract($data, EXTR_SKIP);

        require $file;
    }
}
