<?php
// Mulai sesi
session_start();

// Menghancurkan semua sesi
session_unset();
session_destroy();

// Arahkan pengguna ke halaman login setelah logout
header("Location: login.php"); // Ganti dengan halaman login sesuai kebutuhan
exit();
