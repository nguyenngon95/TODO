<?php

// Database connection
// get values from environment variables
$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$dbName = $_ENV['DB_NAME'];

$connection = "mysql:host=$host;dbname=$dbName";

try {
    $db = new PDO($connection, $user, $pass);
} catch (PDOException $e) {
    $error = 'DB error: ' . $e->getMessage();
    view('error', compact('error'));
    exit;
}