<?php
include('../Config/koneksi.php');

// Mendapatkan ID dari query string
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Ambil data admin berdasarkan ID
    $query = $conn->prepare("SELECT * FROM admins WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $admin = $result->fetch_assoc();
} else {
    die("ID Admin tidak valid.");
}

// Menyiapkan header untuk cetakan
echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .admin-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .admin-details th, .admin-details td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        .admin-details th {
            background-color: #f4f4f4;
        }
        .admin-details td {
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Data Admin</h1>
    <table class="admin-details">
        <tr>
            <th>ID</th>
            <td>' . $admin['id'] . '</td>
        </tr>
        <tr>
            <th>Profil</th>
            <td><img src="../Assets/uploads/' . $admin['profil'] . '" alt="Profil Image" style="width: 100px; height: 100px; object-fit: cover;"></td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>' . $admin['nama'] . '</td>
        </tr>
        <tr>
            <th>Username</th>
            <td>' . $admin['username'] . '</td>
        </tr>
        <tr>
            <th>Password</th>
            <td>' . $admin['password'] . '</td>
        </tr>
        <tr>
            <th>No. Telp</th>
            <td>' . $admin['no_hp'] . '</td>
        </tr>
    </table>
    <div class="text-center">
        <button onclick="window.print();">Print</button>
    </div>
</body>
</html>';
