<?php
include('../Config/koneksi.php');

// Cek apakah id_kasir ada di parameter URL
if (isset($_GET['id_kasir'])) {
    $id_kasir = $_GET['id_kasir'];

    // Periksa apakah kasir dengan id tersebut ada
    $query = $conn->prepare("SELECT * FROM kasir WHERE id = ?");
    $query->bind_param("i", $id_kasir);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Kasir ditemukan, hapus data kasir
        $deleteQuery = $conn->prepare("DELETE FROM kasir WHERE id = ?");
        $deleteQuery->bind_param("i", $id_kasir);

        if ($deleteQuery->execute()) {
            // Jika berhasil menghapus, arahkan ke halaman daftar kasir dengan pesan sukses
            header("Location: kasir.php?message=Kasir berhasil dihapus");
            exit;
        } else {
            // Jika gagal, tampilkan pesan error
            echo "<p class='text-danger'>Gagal menghapus kasir!</p>";
        }
    } else {
        // Jika kasir tidak ditemukan, tampilkan pesan error
        echo "<p class='text-danger'>Kasir tidak ditemukan!</p>";
    }
} else {
    // Jika id_kasir tidak ada, tampilkan pesan error
    echo "<p class='text-danger'>ID Kasir tidak diberikan!</p>";
}
