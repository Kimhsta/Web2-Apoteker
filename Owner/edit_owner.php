<?php
include('../Config/koneksi.php');

// Check if 'id_owner' is set
if (!isset($_GET['id_owner'])) {
    die("ID owner tidak ditemukan.");
}
$id_owner = $_GET['id_owner'];

// Ambil data owner dari database berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM owners WHERE id = ?");
$stmt->bind_param("i", $id_owner);
$stmt->execute();
$result = $stmt->get_result();
$owner = $result->fetch_assoc();

// Check if owner data is found
if (!$owner) {
    die("Owner dengan ID tersebut tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $no_hp = $_POST['no_hp'];
    $profil = $_FILES['profil'];

    // Jika ada file baru, proses upload
    if ($profil['error'] === 0) {
        $uploadDir = '../Assets/uploads/';
        $fileName = uniqid() . '_' . basename($profil['name']);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($profil['tmp_name'], $uploadPath)) {
            // Hapus foto lama jika ada
            if (!empty($owner['profil']) && is_file($uploadDir . $owner['profil'])) {
                unlink($uploadDir . $owner['profil']);
            }

            // Update data owner dengan foto baru
            $stmt = $conn->prepare("UPDATE owners SET nama = ?, profil = ?, username = ?, password = ?, no_hp = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $nama, $fileName, $username, $password, $no_hp, $id_owner);

            if ($stmt->execute()) {
                echo "<script>alert('Owner berhasil diperbarui'); window.location.href = 'owner.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui owner: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Gagal mengunggah foto profil');</script>";
        }
    } else {
        // Jika tidak ada foto baru, update tanpa mengubah foto
        $stmt = $conn->prepare("UPDATE owners SET nama = ?, username = ?, password = ?, no_hp = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nama, $username, $password, $no_hp, $id_owner);

        if ($stmt->execute()) {
            echo "<script>alert('Owner berhasil diperbarui'); window.location.href = 'owner.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui owner: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
}
?>

<!-- Form Edit Owner -->
<form action="edit_owner.php?id_owner=<?php echo $owner['id']; ?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Owner</label>
        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $owner['nama']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" value="<?php echo $owner['username']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="text" name="password" id="password" class="form-control" value="<?php echo $owner['password']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="profil" class="form-label">Profil (Foto)</label>
        <input type="file" name="profil" id="profil" class="form-control" accept="image/*">
        <p>Foto Profil Saat Ini:</p>
        <img src="../Assets/uploads/<?php echo htmlspecialchars($owner['profil']); ?>" alt="Profil Foto" width="100">
    </div>

    <div class="mb-3">
        <label for="no_hp" class="form-label">No. Telepon</label>
        <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?php echo $owner['no_hp']; ?>" required>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary me-2">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    </div>
</form>