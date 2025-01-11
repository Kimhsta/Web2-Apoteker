<?php
// Konfigurasi koneksi database
$host = "localhost"; // Ganti dengan host Anda jika berbeda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "apoteker"; // Nama database yang digunakan

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengatur karakter set menjadi UTF-8
$conn->set_charset("utf8");
