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

// -----------------------------------------------------------------
//  Home
// -----------------------------------------------------------------
$router->get('/', [HomeController::class, 'index']);

// -----------------------------------------------------------------
//  Authentication
// -----------------------------------------------------------------
$router->get('/register', [AuthController::class, 'showRegisterForm']);
$router->post('/register', [AuthController::class, 'register']);
