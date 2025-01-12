<?php
include('../Config/koneksi.php');

// Ambil ID Admin dari parameter URL
$id_admin = $_GET['id'];

if (isset($id_admin)) {
    // Query untuk mendapatkan data admin (termasuk file profil)
    $query = $conn->prepare("SELECT profil FROM admins WHERE id = ?");
    $query->bind_param("i", $id_admin);
    $query->execute();
    $query->bind_result($profil);
    $query->fetch();
    $query->close();

    // Hapus file profil jika ada
    if (!empty($profil)) {
        $filePath = '../Assets/uploads/' . $profil;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Hapus data admin dari database
    $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
    $stmt->bind_param("i", $id_admin);

    if ($stmt->execute()) {
        echo "<script>alert('Admin berhasil dihapus'); window.location.href = 'admin.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus admin: " . $stmt->error . "'); window.location.href = 'admin.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('ID Admin tidak ditemukan'); window.location.href = 'admin.php';</script>";
}
