<?php

/**
 * Database Configuration
 *
 * Returns connection settings for PDO, loaded from .env variables.
 * Must be loaded AFTER config/app.php (which parses .env and defines env()).
 */

return [
    'driver'   => 'mysql',
    'host'     => env('DB_HOST', '127.0.0.1'),
    'port'     => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'juanico'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'charset'  => env('DB_CHARSET', 'utf8mb4'),

    // PDO connection options for security and performance
    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,       // Throw exceptions on DB errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,             // Return associative arrays
        PDO::ATTR_EMULATE_PREPARES   => false,                        // Use real prepared statements (security)
        PDO::ATTR_STRINGIFY_FETCHES  => false,                        // Keep native types (int stays int)
    ],
];
