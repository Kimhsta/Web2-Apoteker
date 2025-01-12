<?php
include('../Config/koneksi.php');

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

        // Masukkan data transaksi ke tabel transaksi
        $queryTransaksi = $conn->prepare("
            INSERT INTO transaksi (id_kasir, kode_produk, jumlah, total_harga, metode_pembayaran) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $queryTransaksi->bind_param("isids", $id_kasir, $kode_produk, $jumlah, $total_harga, $metode_pembayaran);

        if ($queryTransaksi->execute()) {
            echo "<script>alert('Transaksi berhasil ditambahkan!'); window.location.href = 'transaksi.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan transaksi!'); history.back();</script>";
        }
    } else {
        echo "<script>alert('Kode produk tidak ditemukan!'); history.back();</script>";
    }
} else {
?>
    <form method="POST" action="add_transaksi.php">
        <div class="mb-3">
            <label for="id_kasir" class="form-label">Kasir</label>
            <select name="id_kasir" id="id_kasir" class="form-select" required>
                <?php
                $kasirQuery = $conn->query("SELECT id, nama FROM kasir");
                while ($kasir = $kasirQuery->fetch_assoc()) {
                    echo "<option value='{$kasir['id']}'>{$kasir['nama']}</option>";
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
                    echo "<option value='{$obat['kode']}'>{$obat['nama']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                <option value="Cash">Cash</option>
                <option value="Transfer">Transfer</option>
                <option value="E-Wallet">E-Wallet</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
    </form>
<?php
}
?>