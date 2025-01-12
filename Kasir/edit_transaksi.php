<?php
include('../Config/koneksi.php');

// Ambil ID transaksi dari URL
$id_transaksi = $_GET['id'];

// Ambil data transaksi yang akan diedit
$queryTransaksi = $conn->prepare("
    SELECT t.id, t.id_kasir, t.kode_produk, t.jumlah, t.metode_pembayaran, k.nama AS nama_kasir, o.nama AS nama_obat 
    FROM transaksi t 
    JOIN kasir k ON t.id_kasir = k.id 
    JOIN obat o ON t.kode_produk = o.kode 
    WHERE t.id = ?
");
$queryTransaksi->bind_param("i", $id_transaksi);
$queryTransaksi->execute();
$resultTransaksi = $queryTransaksi->get_result();

if ($resultTransaksi->num_rows > 0) {
    $transaksi = $resultTransaksi->fetch_assoc();
} else {
    echo "<script>alert('Data transaksi tidak ditemukan!'); history.back();</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kasir = $_POST['id_kasir'];
    $kode_produk = $_POST['kode_produk'];
    $jumlah = (int)$_POST['jumlah'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Ambil harga obat dari tabel obat
    $queryObat = $conn->prepare("SELECT harga FROM obat WHERE kode = ?");
    $queryObat->bind_param("s", $kode_produk);
    $queryObat->execute();
    $resultObat = $queryObat->get_result();

    if ($resultObat->num_rows > 0) {
        $rowObat = $resultObat->fetch_assoc();
        $harga = (float)$rowObat['harga'];
        $total_harga = $harga * $jumlah; // Hitung total harga

        // Update data transaksi
        $queryUpdate = $conn->prepare("
            UPDATE transaksi SET id_kasir = ?, kode_produk = ?, jumlah = ?, total_harga = ?, metode_pembayaran = ? 
            WHERE id = ?
        ");
        $queryUpdate->bind_param("isidsi", $id_kasir, $kode_produk, $jumlah, $total_harga, $metode_pembayaran, $id_transaksi);

        if ($queryUpdate->execute()) {
            echo "<script>alert('Transaksi berhasil diperbarui!'); window.location.href = 'transaksi.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui transaksi!'); history.back();</script>";
        }
    } else {
        echo "<script>alert('Kode produk tidak ditemukan!'); history.back();</script>";
    }
}
?>

<form method="POST" action="edit_transaksi.php?id=<?= $id_transaksi; ?>">
    <div class="mb-3">
        <label for="id_kasir" class="form-label">Kasir</label>
        <select name="id_kasir" id="id_kasir" class="form-select" required>
            <?php
            $kasirQuery = $conn->query("SELECT id, nama FROM kasir");
            while ($kasir = $kasirQuery->fetch_assoc()) {
                $selected = ($kasir['id'] == $transaksi['id_kasir']) ? 'selected' : '';
                echo "<option value='{$kasir['id']}' {$selected}>{$kasir['nama']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="kode_produk" class="form-label">Obat</label>
        <select name="kode_produk" id="kode_produk" class="form-select" required>
            <?php
            $obatQuery = $conn->query("SELECT kode, nama FROM obat");
            while ($obat = $obatQuery->fetch_assoc()) {
                $selected = ($obat['kode'] == $transaksi['kode_produk']) ? 'selected' : '';
                echo "<option value='{$obat['kode']}' {$selected}>{$obat['nama']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number" name="jumlah" id="jumlah" class="form-control" value="<?= $transaksi['jumlah']; ?>" min="1" required>
    </div>
    <div class="mb-3">
        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
            <option value="Cash" <?= ($transaksi['metode_pembayaran'] == 'Cash') ? 'selected' : ''; ?>>Cash</option>
            <option value="Transfer" <?= ($transaksi['metode_pembayaran'] == 'Transfer') ? 'selected' : ''; ?>>Transfer</option>
            <option value="E-Wallet" <?= ($transaksi['metode_pembayaran'] == 'E-Wallet') ? 'selected' : ''; ?>>E-Wallet</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Update Transaksi</button>
</form>