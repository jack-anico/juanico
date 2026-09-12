<?php
// Seed admin account
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Core/Database.php';

$db = \App\Core\Database::getInstance();
$password = 'Admin123!';
$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT IGNORE INTO users (username, email, password_hash, role) VALUES ('admin', 'admin@juanico.local', :hash, 'admin')";
$db->execute($sql, ['hash' => $hash]);

echo "Admin seeded successfully.\n";
