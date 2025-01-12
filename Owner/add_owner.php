<?php
include('../Config/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $no_hp = $_POST['no_hp'];
    $profil = $_FILES['profil'];

    // Validasi file profil
    if ($profil['error'] === 0) {
        $uploadDir = '../Assets/uploads/';
        $fileName = uniqid() . '_' . basename($profil['name']);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($profil['tmp_name'], $uploadPath)) {
            // Insert data ke database
            $stmt = $conn->prepare("INSERT INTO owners (nama, profil, username, password, no_hp) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nama, $fileName, $username, $password, $no_hp);

            if ($stmt->execute()) {
                echo "<script>alert('Owner berhasil ditambahkan'); window.location.href = 'owner.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan owner: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Gagal mengunggah foto profil');</script>";
        }
    } else {
        echo "<script>alert('Harap pilih file foto profil');</script>";
    }
}
?>

<!-- Form Tambah Owner -->
<form action="add_owner.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Owner</label>
        <input type="text" name="nama" id="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="text" name="password" id="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="profil" class="form-label">Profil (Foto)</label>
        <input type="file" name="profil" id="profil" class="form-control" accept="image/*" required>
    </div>

    <div class="mb-3">
        <label for="no_hp" class="form-label">No. Telepon</label>
        <input type="text" name="no_hp" id="no_hp" class="form-control" required>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary me-2">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    </div>
</form>