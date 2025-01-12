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

// Ambil data sesuai halaman
$result = $conn->prepare("
    SELECT t.id, t.id_kasir, t.kode_produk, t.jumlah, t.total_harga, t.metode_pembayaran, t.waktu, k.nama AS nama_kasir, o.nama AS nama_obat 
    FROM transaksi t 
    JOIN kasir k ON t.id_kasir = k.id 
    JOIN obat o ON t.kode_produk = o.kode 
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
        </div>

        <div class="border bg-white border-secondary border-opacity-75 p-2 mb-2 rounded-3 overflow-hidden">
            <table class="table table-hover align-middle" id="transaksiTable">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">ID Transaksi</th>
                        <th>Kasir</th>
                        <th>Obat</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Metode Pembayaran</th>
                        <th>Waktu</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $queryResult->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?= $row['id']; ?></td>
                            <td><?= $row['nama_kasir']; ?></td>
                            <td><?= $row['nama_obat']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                            <td><?= "Rp. " . number_format($row['total_harga'], 2, ',', '.'); ?></td>
                            <td><?= $row['metode_pembayaran']; ?></td>
                            <td><?= date("d-m-Y H:i", strtotime($row['waktu'])); ?></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm rounded-2" data-bs-toggle="modal" data-bs-target="#editTransaksiModal" onclick="loadEditForm('<?= $row['id']; ?>')">
                                    <i class="bx bx-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm rounded-2" onclick="confirmDelete('<?= $row['id']; ?>')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                                <button class="btn btn-success btn-sm rounded-2" onclick="printTransaksi('<?= $row['id']; ?>')">
                                    <i class="bx bx-printer"></i> Print
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Navigasi Pagination -->
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


    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="tambahTransakasiModal" tabindex="-1" aria-labelledby="tambahTransakasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahTransakasiLabel">Tambah Transakasi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Form akan dimuat di sini menggunakan AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Obat -->
    <div class="modal fade" id="editObatModal" tabindex="-1" aria-labelledby="editObatLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editObatLabel">Edit Data Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editModalContent">
                    <!-- Form akan dimuat di sini menggunakan AJAX -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Pencarian data dalam tabel
    function searchTable() {
        let input = document.getElementById("search").value.toLowerCase();
        let rows = document.querySelectorAll("#transaksiTable tbody tr");
        rows.forEach((row) => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    }
    // Ajax Tambah Transakasi
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('tambahTransaksiModal');
        const modalContent = document.getElementById('modalContent');
        modal.addEventListener('show.bs.modal', function() {
            fetch('add_transaksi.php')
                .then(response => response.text())
                .then(data => {
                    modalContent.innerHTML = data;
                })
                .catch(error => {
                    modalContent.innerHTML = '<p class="text-danger">Gagal memuat form</p>';
                });
        });
    });

    // Ajax Edit Obat
    function loadEditForm(kode_obat) {
        const modalContent = document.getElementById('editModalContent');
        modalContent.innerHTML = '<p class="text-center text-muted">Loading...</p>';
        fetch(`edit_obat.php?kode_obat=${kode_obat}`)
            .then(response => response.text())
            .then(data => {
                modalContent.innerHTML = data;
            })
            .catch(error => {
                modalContent.innerHTML = '<p class="text-danger">Gagal memuat data</p>';
            });
    }

    // Ajax Delete Obat
    function confirmDelete(kode_obat) {
        if (confirm("Apakah Anda yakin ingin menghapus obat ini?")) {
            window.location.href = "delete_obat.php?kode_obat=" + kode_obat;
        }
    }

    // Function to print Obat
    function printObat(id) {
        const printWindow = window.open(`print_obat.php?id=${id}`, '_blank');
        printWindow.focus();
    }
</script>