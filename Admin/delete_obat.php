<?php
include('../Config/koneksi.php');

// Mengecek apakah kode_obat diberikan
if (isset($_GET['kode_obat'])) {
    $kode_obat = $_GET['kode_obat'];

    // Ambil data gambar untuk dihapus dari folder
    $query = $conn->prepare("SELECT gambar FROM obat WHERE kode = ?");
    $query->bind_param("s", $kode_obat);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $gambar = $data['gambar'];

        // Hapus data dari database
        $deleteQuery = $conn->prepare("DELETE FROM obat WHERE kode = ?");
        $deleteQuery->bind_param("s", $kode_obat);

        if ($deleteQuery->execute()) {
            // Hapus gambar dari folder jika ada
            if (!empty($gambar) && file_exists("../Assets/uploads/" . $gambar)) {
                unlink("../Assets/uploads/" . $gambar);
            }

            echo "<script>alert('Data obat berhasil dihapus!'); window.location.href='obat.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data obat.'); window.location.href='obat.php';</script>";
        }
    } else {
        echo "<script>alert('Data obat tidak ditemukan.'); window.location.href='obat.php';</script>";
    }
} else {
    echo "<script>alert('Kode obat tidak diberikan.'); window.location.href='obat.php';</script>";
}
?>