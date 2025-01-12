<?php
include('../Config/koneksi.php');

// Ambil ID Admin dari parameter URL
$id_admin = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $no_hp = $_POST['no_hp'];
    $profil = $_FILES['profil'];

    // Query untuk mendapatkan data admin sebelumnya
    $query = $conn->prepare("SELECT profil FROM admins WHERE id = ?");
    $query->bind_param("i", $id_admin);
    $query->execute();
    $query->bind_result($currentProfil);
    $query->fetch();
    $query->close();

    // Jika ada file baru yang diunggah
    if ($profil['error'] === 0) {
        $uploadDir = '../Assets/uploads/';
        $fileName = uniqid() . '_' . basename($profil['name']);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($profil['tmp_name'], $uploadPath)) {
            // Hapus file lama jika ada
            if (!empty($currentProfil) && file_exists($uploadDir . $currentProfil)) {
                unlink($uploadDir . $currentProfil);
            }
            $profilPath = $fileName;
        } else {
            echo "<script>alert('Gagal mengunggah foto profil baru');</script>";
            $profilPath = $currentProfil; // Gunakan file lama jika unggah gagal
        }
    } else {
        $profilPath = $currentProfil; // Gunakan file lama jika tidak ada unggahan baru
    }

    // Update data ke database
    $stmt = $conn->prepare("UPDATE admins SET nama = ?, username = ?, password = ?, no_hp = ?, profil = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nama, $username, $password, $no_hp, $profilPath, $id_admin);

    if ($stmt->execute()) {
        echo "<script>alert('Data admin berhasil diperbarui'); window.location.href = 'admin.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data admin: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Ambil data admin berdasarkan ID untuk ditampilkan di form
$query = $conn->prepare("SELECT nama, username, password, no_hp, profil FROM admins WHERE id = ?");
$query->bind_param("i", $id_admin);
$query->execute();
$query->bind_result($nama, $username, $password, $no_hp, $profil);
$query->fetch();
$query->close();
?>

<!-- Form Edit Admin -->
<form action="edit_admin.php?id=<?= $id_admin ?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Admin</label>
        <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($nama) ?>" required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($username) ?>" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="text" name="password" id="password" class="form-control" value="<?= htmlspecialchars($password) ?>" required>
    </div>

    <div class="mb-3">
        <label for="profil" class="form-label">Profil (Foto)</label>
        <input type="file" name="profil" id="profil" class="form-control" accept="image/*">
        <?php if (!empty($profil)): ?>
            <div class="mt-2">
                <p>Foto Profil Saat Ini:</p>
                <img src="../Assets/uploads/<?= htmlspecialchars($profil) ?>" alt="Profil Admin" width="100">
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="no_hp" class="form-label">No. Telepon</label>
        <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= htmlspecialchars($no_hp) ?>" required>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
        <a href="admin.php" class="btn btn-secondary">Batal</a>
    </div>
</form>