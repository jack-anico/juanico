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
use App\Controllers\ProductController;
use App\Controllers\AdminController;
use App\Controllers\AdminProductController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\AdminMiddleware;

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
//  Public Products
// -----------------------------------------------------------------
$router->get('/products', [ProductController::class, 'index']);

// -----------------------------------------------------------------
//  Admin
// -----------------------------------------------------------------
$router->get('/admin/dashboard', [AdminController::class, 'dashboard'], [AdminMiddleware::class]);

$router->get('/admin/products', [AdminProductController::class, 'index'], [AdminMiddleware::class]);
$router->get('/admin/products/create', [AdminProductController::class, 'create'], [AdminMiddleware::class]);
$router->post('/admin/products', [AdminProductController::class, 'store'], [AdminMiddleware::class]);
$router->get('/admin/products/edit/{id}', [AdminProductController::class, 'edit'], [AdminMiddleware::class]);
$router->post('/admin/products/update/{id}', [AdminProductController::class, 'update'], [AdminMiddleware::class]);
$router->post('/admin/products/delete/{id}', [AdminProductController::class, 'delete'], [AdminMiddleware::class]);

