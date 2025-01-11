<?php
include('../Config/koneksi.php');

// Mengecek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $gambar = $_FILES['gambar']['name'];
    $jenis_obat = $_POST['jenis_obat'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Upload gambar
    $targetDir = "../Assets/uploads/";
    $targetFile = $targetDir . basename($gambar);
    move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile);

    // Query untuk menyimpan data obat
    $query = $conn->prepare("INSERT INTO obat (kode, nama, gambar, jenis_obat, kategori, harga, stok) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Pastikan bahwa parameter bind sesuai dengan kolom
    $query->bind_param("ssssssi", $kode, $nama, $gambar, $jenis_obat, $kategori, $harga, $stok);

    if ($query->execute()) {
        echo "<script>alert('Obat berhasil ditambahkan!'); window.location.href='obat.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan obat!'); window.location.href='obat.php';</script>";
    }
}
?>

<form action="add_obat.php" method="POST" enctype="multipart/form-data">
    <div class="modal-body">
        <!-- Kode Obat -->
        <div class="mb-3">
            <label for="kode" class="form-label">Kode Obat</label>
            <input type="text" class="form-control" id="kode" name="kode" required>
        </div>

        <!-- Nama Obat -->
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Obat</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>

        <!-- Gambar Obat -->
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Obat</label>
            <input type="file" class="form-control" id="gambar" name="gambar" required>
        </div>

        <!-- Jenis Obat -->
        <div class="mb-3">
            <label for="jenis_obat" class="form-label">Jenis Obat</label>
            <select class="form-select" id="jenis_obat" name="jenis_obat" required>
                <option value="Tablet">Tablet</option>
                <option value="Kapsul">Kapsul</option>
                <option value="Sirup">Sirup</option>
                <option value="Salep">Salep</option>
                <option value="Injeksi">Injeksi</option>
            </select>
        </div>

        <!-- Kategori Obat -->
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori Obat</label>
            <select class="form-select" id="kategori" name="kategori" required>
                <option value="Antibiotik">Antibiotik</option>
                <option value="Antipiretik">Antipiretik</option>
                <option value="Analgesik">Analgesik</option>
                <option value="Antihistamin">Antihistamin</option>
                <option value="Vitamin">Vitamin</option>
                <option value="Antiseptik">Antiseptik</option>
                <option value="Herbal">Herbal</option>
            </select>
        </div>

        <!-- Harga Obat -->
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" step="0.01" required>
        </div>

        <!-- Stok Obat -->
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Tambah Obat</button>
    </div>
</form>