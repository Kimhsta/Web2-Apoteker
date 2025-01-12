<?php
include('../Config/koneksi.php');

// Ambil ID transaksi dari URL
$id_transaksi = $_GET['id'];

// Cek apakah ID transaksi valid
if (isset($id_transaksi) && is_numeric($id_transaksi)) {
    // Hapus data transaksi berdasarkan ID
    $queryDelete = $conn->prepare("DELETE FROM transaksi WHERE id = ?");
    $queryDelete->bind_param("i", $id_transaksi);

    if ($queryDelete->execute()) {
        echo "<script>alert('Transaksi berhasil dihapus!'); window.location.href = 'transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus transaksi!'); history.back();</script>";
    }
} else {
    echo "<script>alert('ID transaksi tidak valid!'); history.back();</script>";
}
