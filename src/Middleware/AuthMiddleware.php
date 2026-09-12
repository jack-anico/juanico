<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Response;

/**
 * AuthMiddleware — Ensures a user is logged in.
 */
class AuthMiddleware
{
    public function handle(): void
    {
        if (!isAuthenticated()) {
            if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
                $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'] ?? url('/');
            }
            $response = new Response();
            $response->redirect(url('/login'));
        }
    }
}
