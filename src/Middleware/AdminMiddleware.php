<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Response;
use App\Repositories\UserRepository;

/**
 * AdminMiddleware — Ensures the logged in user is an admin.
 */
class AdminMiddleware
{
    public function handle(): void
    {
        if (!isAuthenticated()) {
            $response = new Response();
            $response->redirect(url('/login'));
            exit; // exit after redirect
        }

        $userId = authUserId();
        $userRepo = new UserRepository();
        $user = $userRepo->findById($userId);

        if (!$user || $user['role'] !== 'admin') {
            // If they are not an admin, redirect them to the home page or show 403
            $response = new Response();
            $response->redirect(url('/'));
            exit;
        }
    }
}
