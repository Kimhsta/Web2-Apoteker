<?php
// Koneksi ke database
$host = 'localhost';   // Host database
$dbname = 'apoteker';  // Nama database
$username = 'root';    // Username database
$password = '';        // Password database

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode ke exception untuk debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
