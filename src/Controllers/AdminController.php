<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * AdminController — Handles admin dashboard and admin operations.
 */
class AdminController extends BaseController
{
    /**
     * GET /admin/dashboard — Display the admin dashboard.
     */
    public function dashboard(): void
    {
        $this->response->view('admin.dashboard');
    }
}
