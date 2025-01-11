<?php
include('../Config/koneksi.php');

// Periksa apakah ID kasir diberikan
if (isset($_GET['id_kasir'])) {
    $id_kasir = $_GET['id_kasir'];

    // Ambil data kasir berdasarkan ID
    $query = $conn->prepare("SELECT * FROM kasir WHERE id = ?");
    $query->bind_param("i", $id_kasir);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $kasir = $result->fetch_assoc();
    } else {
        echo "<p class='text-danger'>Data kasir tidak ditemukan!</p>";
        exit;
    }
} else {
    echo "<p class='text-danger'>ID kasir tidak diberikan!</p>";
    exit;
}
?>

<form method="post" action="update_kasir.php" enctype="multipart/form-data">
    <input type="hidden" name="id_kasir" value="<?= $kasir['id']; ?>">

    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $kasir['nama']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= $kasir['username']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="text" class="form-control" id="password" name="password" value="<?= $kasir['password']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="no_hp" class="form-label">No. Telp</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $kasir['no_hp']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="profil" class="form-label">Profil</label>
        <input type="file" class="form-control" id="profil" name="profil">
        <p class="form-text">Upload foto baru jika ingin mengganti foto profil.</p>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>