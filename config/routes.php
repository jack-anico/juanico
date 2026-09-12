<?php

/**
 * Route Definitions
 *
 * All application routes are registered here.
 * The $router variable is provided by public/index.php.
 *
 * Pattern: $router->{method}('/path', [ControllerClass::class, 'action']);
 */

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

// -----------------------------------------------------------------
//  Home
// -----------------------------------------------------------------
$router->get('/', [HomeController::class, 'index']);

// -----------------------------------------------------------------
//  Authentication
// -----------------------------------------------------------------
$router->get('/register', [AuthController::class, 'showRegisterForm'], [GuestMiddleware::class]);
$router->post('/register', [AuthController::class, 'register'], [GuestMiddleware::class]);

$router->get('/login', [AuthController::class, 'showLoginForm'], [GuestMiddleware::class]);
$router->post('/login', [AuthController::class, 'login'], [GuestMiddleware::class]);

$router->post('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);

// -----------------------------------------------------------------
//  Admin
// -----------------------------------------------------------------
$router->get('/admin/dashboard', [\App\Controllers\AdminController::class, 'dashboard'], [\App\Middleware\AdminMiddleware::class]);
