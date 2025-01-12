<?php
include('../Config/koneksi.php');
include('header.php');
// Ambil tanggal hari ini
$tanggal_hari_ini = date("l, d F Y");

// Variabel profil dan nama untuk admin
$profil_gambar = 'admin1.jpg'; // Ganti dengan gambar profil yang sesuai
$nama_pemilik = 'Admin Satu'; // Ganti dengan nama admin yang sesuai
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
                <!-- Ikon Pesan -->
                <button class="btn btn-light border rounded-4 message-icon">
                    <i class="bx bx-sign-out-alt rotated-icon" id="log_out" onclick="confirmLogout()"></i>
                </button>
                <div class="d-flex align-items-center">
                    <img src="../../Assets/uploads/<?= htmlspecialchars($profil_gambar); ?>" alt="Profile Image" class="profile-img me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    <div>
                        <h6 class="fw-bold mb-0"><?= $nama_pemilik; ?></h6>
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
                            <p class="card-text" style="color: #8e9baf;">5 Kasir Terdaftar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Obat -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm p-3" style="background-color: #f4f7fb; border-radius: 10px;">
                    <div class="d-flex align-items-center">
                        <i class="bx bxs-pills" style="font-size: 30px; color: #ff7043;"></i>
                        <div class="ms-3">
                            <h5 class="card-title" style="font-weight: 600;">Total Obat</h5>
                            <p class="card-text" style="color: #8e9baf;">50 Jenis Obat Tersedia</p>
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
                            <p class="card-text" style="color: #8e9baf;">100 Transaksi Terakhir</p>
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
                            <p class="card-text" style="color: #8e9baf;">Rp 500.000.000</p>
                        </div>
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