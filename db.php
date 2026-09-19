<?php
// db.php
require 'session.php'; // sets up the session automatically

$host = '127.0.0.1';
$dbname = 'mywebsite';
$username = 'root';
$password = ''; // XAMPP default is empty

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
