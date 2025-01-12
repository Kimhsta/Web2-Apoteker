<?php
include('../Config/koneksi.php');
include('header.php');

// Pagination logic
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit;

// Hitung total data
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM admins");
$totalResult = $totalQuery->fetch_assoc();
$totalRows = $totalResult['total'];
$totalPages = ceil($totalRows / $limit);

// Ambil data sesuai halaman
$result = $conn->prepare("SELECT * FROM admins LIMIT ?, ?");
$result->bind_param("ii", $offset, $limit);
$result->execute();
$queryResult = $result->get_result();
?>

<section class="">
    <div class="content mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Judul -->
            <h2 class="fw-bold text-dark mb-0">Data Admin</h2>

            <!-- Bagian Tombol dan Pencarian -->
            <div class="d-flex align-items-between gap-3">
                <!-- Input Pencarian -->
                <div class="input-group" style="max-width: 200px;">
                    <span class="input-group-text bg-primary text-white"><i class="bx bx-search"></i></span>
                    <input type="text" class="form-control" id="search" placeholder="Cari Admin..." onkeyup="searchTable()">
                </div>

                <!-- Tombol Tambah Admin -->
                <div>
                    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">
                        <i class="bx bx-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </div>

        <div class="border bg-white border-secondary border-opacity-75 p-2 mb-2 rounded-3 overflow-hidden">
            <table class="table table-hover align-middle" id="adminTable">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Profil</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>No. Telp</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $queryResult->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?= $row['id']; ?></td>
                            <td>
                                <img src="../Assets/uploads/<?= $row['profil']; ?>" alt="Profil Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            </td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= $row['password']; ?></td>
                            <td><?= $row['no_hp']; ?></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm rounded-2" data-bs-toggle="modal" data-bs-target="#editAdminModal" onclick="loadEditForm('<?= $row['id']; ?>')">
                                    <i class="bx bx-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm rounded-2" onclick="confirmDelete('<?= $row['id']; ?>')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                                <button class="btn btn-success btn-sm rounded-2" onclick="printAdmin('<?= $row['id']; ?>')">
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

    <!-- Modal Tambah Admin -->
    <div class="modal fade" id="tambahAdminModal" tabindex="-1" aria-labelledby="tambahAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahAdminLabel">Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Form akan dimuat di sini menggunakan AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Admin -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editAdminLabel">Edit Data Admin</h5>
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
    // Ajax Delet Admin
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            window.location.href = 'delete_admin.php?id=' + id;
        }
    }

    function searchTable() {
        let input = document.getElementById("search").value.toLowerCase();
        let rows = document.querySelectorAll("#adminTable tbody tr");
        rows.forEach((row) => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    }

    // Ajax Tambah Admin
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('tambahAdminModal');
        const modalContent = document.getElementById('modalContent');
        modal.addEventListener('show.bs.modal', function() {
            fetch('add_admin.php')
                .then(response => response.text())
                .then(data => {
                    modalContent.innerHTML = data;
                })
                .catch(error => {
                    modalContent.innerHTML = '<p class="text-danger">Gagal memuat form</p>';
                });
        });
    });

    // Ajax Edit Admin
    function loadEditForm(id) {
        const modalContent = document.getElementById('editModalContent');
        modalContent.innerHTML = '<p class="text-center text-muted">Loading...</p>';
        fetch(`edit_admin.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                modalContent.innerHTML = data;
            })
            .catch(error => {
                modalContent.innerHTML = '<p class="text-danger">Gagal memuat data</p>';
            });
    }

    // Function to print Admin
    function printAdmin(id) {
        const printWindow = window.open(`print_admin.php?id=${id}`, '_blank');
        printWindow.focus();
    }
</script>