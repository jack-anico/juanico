<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * HomeController — Handles the home/landing page.
 */
class HomeController extends BaseController
{
    /**
     * GET / — Display the home page.
     */
    public function index(): void
    {
        $this->response->view('home.index');
    }
}
