<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Response;

/**
 * GuestMiddleware — Ensures a user is NOT logged in.
 * Used for login and register routes.
 */
class GuestMiddleware
{
    public function handle(): void
    {
        if (isAuthenticated()) {
            $response = new Response();
            $response->redirect(url('/'));
        }
    }
}
