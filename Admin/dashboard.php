<?php
session_start(); // Memulai session untuk mengambil data login
include('../Config/koneksi.php');
include('header.php');

// Cek apakah session sudah ada, jika tidak maka alihkan ke halaman login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

// Ambil data pengguna dari session
$user_name = $_SESSION['user_name'];
$profil_gambar = $_SESSION['user_profile'];

// Ambil tanggal hari ini
$tanggal_hari_ini = date("l, d F Y");

// Query untuk mengambil informasi lainnya seperti total kasir, obat, dll
$query_kasir = "SELECT COUNT(*) AS total_kasir FROM kasir";
$query_obat = "SELECT COUNT(*) AS total_obat FROM obat";
$query_transaksi = "SELECT COUNT(*) AS total_transaksi FROM transaksi";
$query_pendapatan = "SELECT SUM(total_harga) AS total_pendapatan FROM transaksi";

$kasir_result = $conn->query($query_kasir);
$obat_result = $conn->query($query_obat);
$transaksi_result = $conn->query($query_transaksi);
$pendapatan_result = $conn->query($query_pendapatan);

$kasir_data = $kasir_result->fetch_assoc();
$obat_data = $obat_result->fetch_assoc();
$transaksi_data = $transaksi_result->fetch_assoc();
$pendapatan_data = $pendapatan_result->fetch_assoc();
?>

<section class="mt-4 me-4 ms-4">
    <div class="content mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Judul dan Tanggal -->
            <div>
                <h2 class="fw-bold text-dark mb-0">Dashboard</h2>
                <p class="text-muted"><?= $tanggal_hari_ini; ?></p>
            </div>

            <!-- Bagian Profil -->
            <div class="d-flex align-items-center gap-4">
                <!-- Ikon Pesan Logout -->
                <button class="btn btn-outline-danger rounded-3 d-flex justify-content-center align-items-center ms-4 me-4" style="width: 45px; height: 45px;" onclick="confirmLogout()">
                    <i class="bx bx-exit" id="log_out" style="font-size: 1.5rem;"></i>
                </button>
                <div class="d-flex align-items-center">
                    <img src="../Assets/uploads/<?= htmlspecialchars($profil_gambar); ?>" alt="Profile Image" class="profile-img me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    <div>
                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($user_name); ?></h6>
                        <p class="mb-0 text-muted">Admin</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Total Kasir -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm p-3" style="background-color: #f4f7fb; border-radius: 10px;">
                    <div class="d-flex align-items-center">
                        <i class="bx bxs-user-circle" style="font-size: 30px; color: #3b6bff;"></i>
                        <div class="ms-3">
                            <h5 class="card-title" style="font-weight: 600;">Total Kasir</h5>
                            <p class="card-text" style="color: #8e9baf;"><?= $kasir_data['total_kasir']; ?> Kasir Terdaftar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Obat -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm p-3" style="background-color: #f4f7fb; border-radius: 10px;">
                    <div class="d-flex align-items-center">
                        <i class="bx bxs-capsule" style="font-size: 30px; color: #ff7043;"></i>
                        <div class="ms-3">
                            <h5 class="card-title" style="font-weight: 600;">Total Obat</h5>
                            <p class="card-text" style="color: #8e9baf;"><?= $obat_data['total_obat']; ?> Jenis Obat Tersedia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm p-3" style="background-color: #f4f7fb; border-radius: 10px;">
                    <div class="d-flex align-items-center">
                        <i class="bx bxs-cart" style="font-size: 30px; color: #4caf50;"></i>
                        <div class="ms-3">
                            <h5 class="card-title" style="font-weight: 600;">Total Transaksi</h5>
                            <p class="card-text" style="color: #8e9baf;"><?= $transaksi_data['total_transaksi']; ?> Transaksi Terakhir</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm p-3" style="background-color: #f4f7fb; border-radius: 10px;">
                    <div class="d-flex align-items-center">
                        <i class="bx bxs-wallet" style="font-size: 30px; color: #3b6bff;"></i>
                        <div class="ms-3">
                            <h5 class="card-title" style="font-weight: 600;">Total Pendapatan</h5>
                            <p class="card-text" style="color: #8e9baf;">Rp <?= number_format($pendapatan_data['total_pendapatan'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Konfirmasi Logout
    function confirmLogout() {
        if (confirm("Apakah Anda yakin ingin keluar?")) {
            window.location.href = "logout.php"; // Ganti dengan halaman logout yang sesuai
        }
    }
</script>