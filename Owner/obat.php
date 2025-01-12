<?php
include('../Config/koneksi.php');
include('header.php');

// Pagination logic
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit;

// Hitung total data
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM obat");
$totalResult = $totalQuery->fetch_assoc();
$totalRows = $totalResult['total'];
$totalPages = ceil($totalRows / $limit);

// Ambil data sesuai halaman
$result = $conn->prepare("SELECT * FROM obat LIMIT ?, ?");
$result->bind_param("ii", $offset, $limit);
$result->execute();
$queryResult = $result->get_result();
?>

<section class="">
    <div class="content mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Judul -->
            <h2 class="fw-bold text-dark mb-0">Data Obat</h2>

            <!-- Bagian Tombol dan Pencarian -->
            <div class="d-flex align-items-between gap-3">
                <!-- Input Pencarian -->
                <div class="input-group" style="max-width: 200px;">
                    <span class="input-group-text bg-primary text-white"><i class="bx bx-search"></i></span>
                    <input type="text" class="form-control" id="search" placeholder="Cari Obat..." onkeyup="searchTable()">
                </div>
            </div>
        </div>

        <div class="border bg-white border-secondary border-opacity-75 p-2 mb-2 rounded-3 overflow-hidden">
            <table class="table table-hover align-middle" id="obatTable">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">Kode</th>
                        <th>Nama</th>
                        <th>Gambar</th>
                        <th>Stok</th>
                        <th>Jenis Obat</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $queryResult->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?= $row['kode']; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td>
                                <img src="../Assets/uploads/<?= $row['gambar']; ?>" alt="Gambar Obat" style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td><?= $row['stok']; ?></td>
                            <td><?= $row['jenis_obat']; ?></td>
                            <td><?= $row['kategori']; ?></td>
                            <td><?= "Rp. " . number_format($row['harga'], 2, ',', '.'); ?></td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm rounded-2" onclick="printPetugas('<?= $row['kode']; ?>')">
                                    <i class="bx bx-printer"></i> Print
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Navigasi Previous dan Next -->
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
        let rows = document.querySelectorAll("#obatTable tbody tr");
        rows.forEach((row) => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    }

    // Function to print Obat
    function printPetugas(kode_obat) {
        const printWindow = window.open(`print_obat.php?kode_obat=${kode_obat}`, '_blank');
        printWindow.focus();
    }
</script>