<?php
require 'src/Database.php';
require 'src/functions.php';

try {
    $db = db();
    $stmt = $db->query("SELECT * FROM users WHERE email = 'admin@juanico.local'");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        print_r($user);
    } else {
        echo "Admin user not found in the database.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
