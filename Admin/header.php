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
    <!-- <link href="../Assets/css/header.css" rel="stylesheet"> -->
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f1f5ffff
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: #ffffffff;
            color: #4c4c4cff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding-top: 10px;
            transition: width 0.3s ease;
        }

        /* Sidebar Header */
        .sidebar__header {
            display: flex;
            align-items: center;
            background-color: #fff;
            justify-content: space-between;
            /* Atur jarak antara hamburger dan logo */
            padding: 10px 10px;
            /* Sesuaikan padding */
        }

        /* Mengatur warna ikon hanya di sidebar__header */
        .sidebar__header .hamburger {
            color: rgb(0, 0, 0);
            /* Contoh warna kuning emas */
        }

        /* Mengatur ukuran logo */
        .sidebar__logo img {
            width: 120px;
            /* Lebar logo */
            height: auto;
            /* Menjaga proporsi */
            margin-right: 25px;
            /* Jarak di kiri logo */
            display: block;
            /* Memastikan logo terpusat */
        }


        .sidebar__link {
            text-decoration: none;
            color: inherit;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1rem;
            border-radius: 10px;
            margin: 5px 15px;
            transition: background 0.3s, transform 0.2s;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar__link:hover {
            background: #6fc2eeff;
            transform: scale(1.05);
        }

        .sidebar__link.active {
            background: #47b9f8ff;
            font-weight: bold;
        }

        .sidebar__icon {
            font-size: 1.3rem;
        }

        .sidebar__text {
            display: inline-block;
            transition: opacity 0.3s, visibility 0.3s;
        }

        /* Content Wrapper */
        .content {
            margin-left: 260px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            background-color: #f1f5ffff;
        }

        .hamburger {
            margin: 10px 20px;
            font-size: 1.8rem;
            color: #fff;
            cursor: pointer;
        }


        /* Warna khusus untuk Dashboard (hanya jika aktif) */
        .sidebar__link.active {
            background: #47b9f8ff;
            /* Warna latar belakang */
            color: rgb(255, 255, 255);
            /* Warna teks hitam */
            font-weight: bold;
        }

        .sidebar__link.active .sidebar__icon {
            color: rgb(255, 255, 255);
            /* Warna ikon hitam */
        }

        @media (max-width: 768px) {
            .hamburger {
                margin: 10px auto;
                display: block;
            }

            /* Responsive Styles */
            .sidebar {
                width: 70px;
            }

            .content {
                margin-left: 70px;
            }

            .sidebar__text {
                visibility: hidden;
                opacity: 0;
            }

            .hamburger {
                left: 80px;
                /* Adjust position based on collapsed sidebar */
            }
        }
    </style>
    <title>Apoteker Medika Sore</title>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar shadow ms">
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
        <a href="kasir.php" class="sidebar__link">
            <i class="bx bx-wallet sidebar__icon"></i>
            <span class="sidebar__text">Kasir</span>
        </a>
        <a href="obat.php" class="sidebar__link">
            <i class="bx bx-capsule sidebar__icon"></i>
            <span class="sidebar__text">Obat</span>
        </a>
        <a href="transaksi.php" class="sidebar__link">
            <i class="bx bx-shopping-bag sidebar__icon"></i>
            <span class="sidebar__text">Penjualan</span>
        </a>
    </aside>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Assets/scripts/header.js"></script> <!-- Link ke file JS -->
</body>

</html>