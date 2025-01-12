<?php
include('../Config/koneksi.php');

// Mengecek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $id_kasir = $_POST['id_kasir'];
    $kode_produk = $_POST['kode_produk'];
    $jumlah = $_POST['jumlah'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Mendapatkan data harga dari tabel obat
    $query_obat = $conn->prepare("SELECT harga, stok FROM obat WHERE kode = ?");
    $query_obat->bind_param("s", $kode_produk);
    $query_obat->execute();
    $result_obat = $query_obat->get_result();

    if ($result_obat->num_rows > 0) {
        $data_obat = $result_obat->fetch_assoc();
        $harga = $data_obat['harga'];
        $stok = $data_obat['stok'];

        // Validasi stok cukup
        if ($stok >= $jumlah) {
            $total_harga = $harga * $jumlah;

            // Query untuk menyimpan data transaksi
            $query = $conn->prepare("INSERT INTO transaksi (id_kasir, kode_produk, jumlah, total_harga, metode_pembayaran, waktu) VALUES (?, ?, ?, ?, ?, NOW())");
            $query->bind_param("isids", $id_kasir, $kode_produk, $jumlah, $total_harga, $metode_pembayaran);

            if ($query->execute()) {
                // Update stok obat
                $stok_baru = $stok - $jumlah;
                $update_stok = $conn->prepare("UPDATE obat SET stok = ? WHERE kode = ?");
                $update_stok->bind_param("is", $stok_baru, $kode_produk);
                $update_stok->execute();

                echo "<script>alert('Transaksi berhasil ditambahkan!'); window.location.href='transaksi.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan transaksi!'); window.location.href='transaksi.php';</script>";
            }
        } else {
            echo "<script>alert('Stok tidak mencukupi!'); window.location.href='transaksi.php';</script>";
        }
    } else {
        echo "<script>alert('Produk tidak ditemukan!'); window.location.href='transaksi.php';</script>";
    }
}
?>

<form action="add_transaksi.php" method="POST">
    <div class="modal-body">
        <!-- ID Kasir -->
        <div class="mb-3">
            <label for="id_kasir" class="form-label">ID Kasir</label>
            <input type="number" class="form-control" id="id_kasir" name="id_kasir" required>
        </div>

        <!-- Kode Produk -->
        <div class="mb-3">
            <label for="kode_produk" class="form-label">Kode Produk</label>
            <input type="text" class="form-control" id="kode_produk" name="kode_produk" required>
        </div>

        <!-- Jumlah -->
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
        </div>

        <!-- Metode Pembayaran -->
        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                <option value="Tunai">Tunai</option>
                <option value="OVO">OVO</option>
                <option value="DANA">DANA</option>
                <option value="GoPay">GoPay</option>
                <option value="Kartu Kredit">Kartu Kredit</option>
                <option value="Transfer Bank">Transfer Bank</option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
    </div>
</form>