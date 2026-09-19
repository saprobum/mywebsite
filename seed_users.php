<?php
require 'db.php';

$users = [
    ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'password' => 'password123'],
    ['name' => 'Bob Smith',     'email' => 'bob@example.com',   'password' => 'password123'],
    ['name' => 'Carol Davis',   'email' => 'carol@example.com', 'password' => 'password123'],
    ['name' => 'David Lee',     'email' => 'david@example.com', 'password' => 'password123'],
];

$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

foreach ($users as $user) {
    $hashed = password_hash($user['password'], PASSWORD_DEFAULT);
    $stmt->execute([$user['name'], $user['email'], $hashed]);
    echo "Created: {$user['email']}<br>";
}

echo "<br>Done. All 4 users created with password: password123";