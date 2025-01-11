<?php
include('../Config/koneksi.php');
include('header.php');

// Pagination logic
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit;

// Hitung total data
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM transaksi");
$totalResult = $totalQuery->fetch_assoc();
$totalRows = $totalResult['total'];
$totalPages = ceil($totalRows / $limit);

// Ambil data sesuai halaman dengan join tabel transaksi dan kasir
$result = $conn->prepare("
    SELECT transaksi.*, kasir.nama AS nama_kasir
    FROM transaksi
    JOIN kasir ON transaksi.id_kasir = kasir.id
    LIMIT ?, ?
");
$result->bind_param("ii", $offset, $limit);
$result->execute();
$queryResult = $result->get_result();
?>

<section class="">
    <div class="content mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">Data Transaksi</h2>

            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text bg-primary text-white"><i class="bx bx-search"></i></span>
                <input type="text" class="form-control" id="search" placeholder="Cari Transaksi..." onkeyup="searchTable()">
            </div>
        </div>

        <div class="border bg-white border-secondary border-opacity-75 p-2 mb-2 rounded-3 overflow-hidden">
            <table class="table table-hover align-middle" id="transaksiTable">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Nama Kasir</th> <!-- Menampilkan Nama Kasir -->
                        <th>Kode Obat</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Metode Pembayaran</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $queryResult->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?= $row['id']; ?></td>
                            <td><?= $row['nama_kasir']; ?></td> <!-- Menampilkan nama kasir -->
                            <td><?= $row['kode_produk']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                            <td><?= "Rp. " . number_format($row['total_harga'], 2, ',', '.'); ?></td>
                            <td><?= $row['metode_pembayaran']; ?></td>
                            <td><?= $row['waktu']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <nav class="mt-4">
                <ul class="pagination d-flex justify-content-between align-items-center me-4 ms-4">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo; Previous</span>
                        </a>
                    </li>

                    <div class="d-flex justify-content-center flex-grow-1">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </div>

                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">Next &raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<script>
    function searchTable() {
        let input = document.getElementById("search").value.toLowerCase();
        let rows = document.querySelectorAll("#transaksiTable tbody tr");
        rows.forEach((row) => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    }
</script>