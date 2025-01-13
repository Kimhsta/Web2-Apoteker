<?php
include('../Config/koneksi.php');

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kasir = $_POST['id_kasir'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Password tidak di-hash
    $no_hp = $_POST['no_hp'];

    // Periksa apakah ada file yang diupload
    if (isset($_FILES['profil']) && $_FILES['profil']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['profil']['tmp_name'];
        $fileName = basename($_FILES['profil']['name']);
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedExt = ['jpg', 'jpeg', 'png'];

        // Validasi ekstensi file
        if (in_array(strtolower($fileExt), $allowedExt)) {
            $uploadDir = '../Assets/Kasir/';
            $newFileName = 'kasir_' . $id_kasir . '.' . $fileExt;
            $filePath = $uploadDir . $newFileName;

            // Pindahkan file yang diupload
            if (move_uploaded_file($fileTmp, $filePath)) {
                // Update database dengan file profil baru
                $query = $conn->prepare("UPDATE kasir SET nama = ?, username = ?, password = ?, no_hp = ?, profil = ? WHERE id = ?");
                $query->bind_param("sssssi", $nama, $username, $password, $no_hp, $newFileName, $id_kasir);
            } else {
                echo "<p class='text-danger'>Gagal mengupload file!</p>";
                exit;
            }
        } else {
            echo "<p class='text-danger'>Format file tidak valid! Hanya JPG, JPEG, atau PNG yang diperbolehkan.</p>";
            exit;
        }
    } else {
        // Jika tidak ada file yang diupload, hanya update data lain
        $query = $conn->prepare("UPDATE kasir SET nama = ?, username = ?, password = ?, no_hp = ? WHERE id = ?");
        $query->bind_param("ssssi", $nama, $username, $password, $no_hp, $id_kasir);
    }

    // Eksekusi query
    if ($query->execute()) {
        echo "<script>alert('Data kasir berhasil diperbarui!'); window.location.href = 'kasir.php';</script>";
    } else {
        echo "<p class='text-danger'>Gagal memperbarui data kasir! Silakan coba lagi.</p>";
    }
} else {
    echo "<p class='text-danger'>Permintaan tidak valid!</p>";
}
