<?php
include('../Config/koneksi.php');

// Mengecek apakah kode_obat diberikan
if (isset($_GET['kode_obat'])) {
    $kode_obat = $_GET['kode_obat'];

    // Ambil data obat berdasarkan kode
    $query = $conn->prepare("SELECT * FROM obat WHERE kode = ?");
    $query->bind_param("s", $kode_obat);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $obat = $result->fetch_assoc();
    } else {
        echo "<p class='text-danger'>Data obat tidak ditemukan.</p>";
        exit;
    }
} else {
    echo "<p class='text-danger'>Kode obat tidak diberikan.</p>";
    exit;
}

// Mengecek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $gambar = $_FILES['gambar']['name'];
    $jenis_obat = $_POST['jenis_obat'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Jika gambar baru diupload
    if (!empty($gambar)) {
        $targetDir = "../Assets/uploads/";
        $targetFile = $targetDir . basename($gambar);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile);

        // Update dengan gambar baru
        $query = $conn->prepare("UPDATE obat SET nama = ?, gambar = ?, jenis_obat = ?, kategori = ?, harga = ?, stok = ? WHERE kode = ?");
        $query->bind_param("ssssdis", $nama, $gambar, $jenis_obat, $kategori, $harga, $stok, $kode);
    } else {
        // Update tanpa mengganti gambar
        $query = $conn->prepare("UPDATE obat SET nama = ?, jenis_obat = ?, kategori = ?, harga = ?, stok = ? WHERE kode = ?");
        $query->bind_param("sssdis", $nama, $jenis_obat, $kategori, $harga, $stok, $kode);
    }

    if ($query->execute()) {
        echo "<script>alert('Data obat berhasil diperbarui!'); window.location.href='obat.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data obat.');</script>";
    }
}
?>

<!-- Form Edit Obat -->
<form action="edit_obat.php?kode_obat=<?= $kode_obat; ?>" method="POST" enctype="multipart/form-data">
    <div class="modal-body">
        <!-- Kode Obat -->
        <div class="mb-3">
            <label for="kode" class="form-label">Kode Obat</label>
            <input type="text" class="form-control" id="kode" name="kode" value="<?= $obat['kode']; ?>" readonly>
        </div>

        <!-- Nama Obat -->
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Obat</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $obat['nama']; ?>" required>
        </div>

        <!-- Gambar Obat -->
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Obat</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
            <p class="text-muted mt-2">Gambar saat ini:</p>
            <img src="../Assets/uploads/<?= $obat['gambar']; ?>" alt="Gambar Obat" style="width: 50px; height: 50px; object-fit: cover;">
        </div>

        <!-- Jenis Obat -->
        <div class="mb-3">
            <label for="jenis_obat" class="form-label">Jenis Obat</label>
            <select class="form-select" id="jenis_obat" name="jenis_obat" required>
                <option value="Tablet" <?= ($obat['jenis_obat'] == 'Tablet') ? 'selected' : ''; ?>>Tablet</option>
                <option value="Kapsul" <?= ($obat['jenis_obat'] == 'Kapsul') ? 'selected' : ''; ?>>Kapsul</option>
                <option value="Sirup" <?= ($obat['jenis_obat'] == 'Sirup') ? 'selected' : ''; ?>>Sirup</option>
                <option value="Salep" <?= ($obat['jenis_obat'] == 'Salep') ? 'selected' : ''; ?>>Salep</option>
                <option value="Injeksi" <?= ($obat['jenis_obat'] == 'Injeksi') ? 'selected' : ''; ?>>Injeksi</option>
            </select>
        </div>

        <!-- Kategori Obat -->
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori Obat</label>
            <select class="form-select" id="kategori" name="kategori" required>
                <option value="Antibiotik" <?= ($obat['kategori'] == 'Antibiotik') ? 'selected' : ''; ?>>Antibiotik</option>
                <option value="Antipiretik" <?= ($obat['kategori'] == 'Antipiretik') ? 'selected' : ''; ?>>Antipiretik</option>
                <option value="Analgesik" <?= ($obat['kategori'] == 'Analgesik') ? 'selected' : ''; ?>>Analgesik</option>
                <option value="Antihistamin" <?= ($obat['kategori'] == 'Antihistamin') ? 'selected' : ''; ?>>Antihistamin</option>
                <option value="Vitamin" <?= ($obat['kategori'] == 'Vitamin') ? 'selected' : ''; ?>>Vitamin</option>
                <option value="Antiseptik" <?= ($obat['kategori'] == 'Antiseptik') ? 'selected' : ''; ?>>Antiseptik</option>
                <option value="Herbal" <?= ($obat['kategori'] == 'Herbal') ? 'selected' : ''; ?>>Herbal</option>
            </select>
        </div>

        <!-- Harga Obat -->
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" step="0.01" value="<?= $obat['harga']; ?>" required>
        </div>

        <!-- Stok Obat -->
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" value="<?= $obat['stok']; ?>" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-warning">Perbarui Data</button>
    </div>
</form>