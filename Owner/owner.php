<?php
include('../Config/koneksi.php');
include('header.php');
// Pagination logic
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit;

// Hitung total data
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM owners");
$totalResult = $totalQuery->fetch_assoc();
$totalRows = $totalResult['total'];
$totalPages = ceil($totalRows / $limit);

// Ambil data sesuai halaman
$result = $conn->prepare("SELECT * FROM owners LIMIT ?, ?");
$result->bind_param("ii", $offset, $limit);
$result->execute();
$queryResult = $result->get_result();
?>

<section class="">
    <div class="content mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Judul -->
            <h2 class="fw-bold text-dark mb-0">Data Owner</h2>

            <!-- Bagian Tombol dan Pencarian -->
            <div class="d-flex align-items-between gap-3">
                <!-- Input Pencarian -->
                <div class="input-group" style="max-width: 200px;">
                    <span class="input-group-text bg-primary text-white"><i class="bx bx-search"></i></span>
                    <input type="text" class="form-control" id="search" placeholder="Cari Owner..." onkeyup="searchTable()">
                </div>

                <!-- Tombol Tambah Owner -->
                <div>
                    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahOwnerModal">
                        <i class="bx bx-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </div>

        <div class="border bg-white border-secondary border-opacity-75 p-2 mb-2 rounded-3 overflow-hidden">
            <table class="table table-hover align-middle" id="ownerTable">
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
                                <button class="btn btn-warning btn-sm rounded-2" data-bs-toggle="modal" data-bs-target="#editOwnerModal" onclick="loadEditForm('<?= $row['id']; ?>')">
                                    <i class="bx bx-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm rounded-2" onclick="confirmDelete('<?= $row['id']; ?>')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                                <button class="btn btn-success btn-sm rounded-2" onclick="printOwner('<?= $row['id']; ?>')">
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

    <!-- Modal Tambah Owner -->
    <div class="modal fade" id="tambahOwnerModal" tabindex="-1" aria-labelledby="tambahOwnerLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahOwnerLabel">Tambah Owner Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Form akan dimuat di sini menggunakan AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Owner -->
    <div class="modal fade" id="editOwnerModal" tabindex="-1" aria-labelledby="editOwnerLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editOwnerLabel">Edit Data Owner</h5>
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
        let rows = document.querySelectorAll("#ownerTable tbody tr");
        rows.forEach((row) => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    }

    // Ajax Tambah Owner
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('tambahOwnerModal');
        const modalContent = document.getElementById('modalContent');
        modal.addEventListener('show.bs.modal', function() {
            fetch('add_owner.php')
                .then(response => response.text())
                .then(data => {
                    modalContent.innerHTML = data;
                })
                .catch(error => {
                    modalContent.innerHTML = '<p class="text-danger">Gagal memuat form</p>';
                });
        });
    });

    // Ajax Edit Owner
    function loadEditForm(id_owner) {
        const modalContent = document.getElementById('editModalContent');
        modalContent.innerHTML = '<p class="text-center text-muted">Loading...</p>';
        fetch(`edit_owner.php?id_owner=${id_owner}`)
            .then(response => response.text())
            .then(data => {
                modalContent.innerHTML = data;
            })
            .catch(error => {
                modalContent.innerHTML = '<p class="text-danger">Gagal memuat data</p>';
            });
    }

    // Ajax Delet Owner
    function confirmDelete(id_owner) {
        if (confirm("Apakah Anda yakin ingin menghapus Owner ini?")) {
            window.location.href = "delete_owner.php?id_owner=" + id_owner;
        }
    }

    // Function to print Owner
    function printOwner(id_owner) {
        const printWindow = window.open(`print_owner.php?id_owner=${id_owner}`, '_blank');
        printWindow.focus();
    }
</script>