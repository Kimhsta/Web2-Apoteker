<?php
session_start();

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Ambil nama admin dari sesi
$adminName = $_SESSION['admin_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="../Assets/css/header.css" rel="stylesheet">
    <title>Apoteker Medika Sore</title>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar__header mb-4">
            <!-- Hamburger Menu -->
            <i class="bx bx-menu hamburger" onclick="toggleSidebar()"></i>
            <div class="sidebar__logo">
                <img class="sidebar__text" src="../Assets/img/LOGO.svg" alt="Logo Apoteker">
            </div>
        </div>
        <a href="#" class="sidebar__link active">
            <i class="bx bx-grid-alt sidebar__icon"></i>
            <span class="sidebar__text">Dashboard</span>
        </a>
        <!-- <a href="kasir.php" class="sidebar__link">
            <i class="bx bx-user-circle sidebar__icon"></i>
            <span class="sidebar__text">Kasir</span>
        </a> -->
        <a href="kasir.php" class="sidebar__link">
            <i class="bx bx-wallet sidebar__icon"></i>
            <span class="sidebar__text">Kasir</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-folder sidebar__icon"></i>
            <span class="sidebar__text">Owner</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-capsule sidebar__icon"></i>
            <span class="sidebar__text">Obat</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-shopping-bag sidebar__icon"></i>
            <span class="sidebar__text">Penjualan</span>
        </a>
    </aside>

    <!-- Content -->
    <div class="content">
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Assets/scripts/header.js"></script> <!-- Link ke file JS -->
</body>

</html>