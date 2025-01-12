<?php
include('../Config/koneksi.php');

// Ambil ID owner dari URL
$id_owner = $_GET['id_owner'];

// Ambil data owner dari database untuk mendapatkan nama file foto profil
$stmt = $conn->prepare("SELECT * FROM owners WHERE id = ?");
$stmt->bind_param("i", $id_owner);
$stmt->execute();
$result = $stmt->get_result();
$owner = $result->fetch_assoc();

if ($owner) {
    // Hapus foto profil dari direktori upload
    $profilPath = '../Assets/uploads/' . $owner['profil'];
    if (file_exists($profilPath)) {
        unlink($profilPath); // Menghapus file foto profil
    }

    // Hapus data owner dari database
    $stmt = $conn->prepare("DELETE FROM owners WHERE id = ?");
    $stmt->bind_param("i", $id_owner);

    if ($stmt->execute()) {
        echo "<script>alert('Owner berhasil dihapus'); window.location.href = 'owner.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus owner: " . $stmt->error . "');</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Owner tidak ditemukan'); window.location.href = 'owner.php';</script>";
}
