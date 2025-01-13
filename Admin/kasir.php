<?php
include('../Config/koneksi.php');
include('header.php');
// Pagination logic
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit;

// Hitung total data
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM kasir");
$totalResult = $totalQuery->fetch_assoc();
$totalRows = $totalResult['total'];
$totalPages = ceil($totalRows / $limit);

// Ambil data sesuai halaman
$result = $conn->prepare("SELECT * FROM kasir LIMIT ?, ?");
$result->bind_param("ii", $offset, $limit);
$result->execute();
$queryResult = $result->get_result();
?>

<section class="">
    <div class="content mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Judul -->
            <h2 class="fw-bold text-dark mb-0">Data Kasir</h2>

            <!-- Bagian Tombol dan Pencarian -->
            <div class="d-flex align-items-between gap-3">
                <!-- Input Pencarian -->
                <div class="input-group" style="max-width: 200px;">
                    <span class="input-group-text bg-primary text-white"><i class="bx bx-search"></i></span>
                    <input type="text" class="form-control" id="search" placeholder="Cari Kasir..." onkeyup="searchTable()">
                </div>

                <!-- Tombol Tambah Kasir -->
                <div>
                    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahKasirModal">
                        <i class="bx bx-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </div>

        <div class="border bg-white border-secondary border-opacity-75 p-2 mb-2 rounded-3 overflow-hidden">
            <table class="table table-hover align-middle" id="kasirTable">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Profil</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>password</th>
                        <th>No. Telp</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $queryResult->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?= $row['id']; ?></td>
                            <td>
                                <img src="../Assets/Kasir/<?= $row['profil']; ?>" alt="Profil Image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 25%;">
                            </td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= $row['password']; ?></td>
                            <td><?= $row['no_hp']; ?></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm rounded-2" data-bs-toggle="modal" data-bs-target="#editKasirModal" onclick="loadEditForm('<?= $row['id']; ?>')">
                                    <i class="bx bx-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm rounded-2" onclick="confirmDelete('<?= $row['id']; ?>')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                                <button class="btn btn-success btn-sm rounded-2" onclick="printPetugas('<?= $row['id']; ?>')">
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
    <!-- Modal Tambah Kasir -->
    <div class="modal fade" id="tambahKasirModal" tabindex="-1" aria-labelledby="tambahKasirLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahKasirLabel">Tambah Kasir Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Form akan dimuat di sini menggunakan AJAX -->
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit Kasir -->
    <div class="modal fade" id="editKasirModal" tabindex="-1" aria-labelledby="editKasirLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editKasirLabel">Edit Data Kasir</h5>
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
    function searchTable() {
        let input = document.getElementById("search").value.toLowerCase();
        let rows = document.querySelectorAll("#kasirTable tbody tr");
        rows.forEach((row) => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    }

    // Ajax Tambah  Kasir
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('tambahKasirModal');
        const modalContent = document.getElementById('modalContent');
        modal.addEventListener('show.bs.modal', function() {
            fetch('add_Kasir.php')
                .then(response => response.text())
                .then(data => {
                    modalContent.innerHTML = data;
                })
                .catch(error => {
                    modalContent.innerHTML = '<p class="text-danger">Gagal memuat form</p>';
                });
        });
    });

    // Ajax Edit Kasir
    function loadEditForm(id_kasir) {
        const modalContent = document.getElementById('editModalContent');
        modalContent.innerHTML = '<p class="text-center text -muted">Loading...</p>';
        fetch(`edit_kasir.php?id_kasir=${id_kasir}`)
            .then(response => response.text())
            .then(data => {
                modalContent.innerHTML = data;
            })
            .catch(error => {
                modalContent.innerHTML = '<p class="text-danger">Gagal memuat data</p>';
            });
    }

    //Ajax Delet Kasir
    function confirmDelete(id_kasir) {
        if (confirm("Apakah Anda yakin ingin menghapus Kasir ini?")) {
            window.location.href = "delete_kasir.php?id_kasir=" + id_kasir;
        }
    }

    // Function to print Kasir
    function printPetugas(id_kasir) {
        const printWindow = window.open(`print_kasir.php?id_kasir=${id_kasir}`, '_blank');
        printWindow.focus();
    }
</script>