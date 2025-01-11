<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="../Assets/css/header.css" rel="stylesheet">
    <title>Apoteker Medika Sore</title>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar__header mb-4">
            <!-- Hamburger Menu -->
            <i class="bx bx-menu hamburger" onclick="toggleSidebar()"></i>
            <div class="sidebar__logo">
                <img class="sidebar__text" src="../Assets/img/LOGO.svg" alt="Logo Apoteker">
            </div>
        </div>
        <a href="#" class="sidebar__link active">
            <i class="bx bx-grid-alt sidebar__icon"></i>
            <span class="sidebar__text">Dashboard</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-user-circle sidebar__icon"></i>
            <span class="sidebar__text">Admin</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-wallet sidebar__icon"></i>
            <span class="sidebar__text">Kasir</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-folder sidebar__icon"></i>
            <span class="sidebar__text">Owner</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-capsule sidebar__icon"></i>
            <span class="sidebar__text">Obat</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-shopping-bag sidebar__icon"></i>
            <span class="sidebar__text">Penjualan</span>
        </a>
    </aside>

    <!-- Content -->
    <div class="content">
        <h1>Welcome to the Dashboard</h1>
        <p>Use the menu to navigate through different sections of the application.</p>
    </div>
    <!-- Content -->
    <div class="content">
        <h1 class="text-center mb-4">Admin Dashboard</h1>
        <div class="row">
            <!-- Card Total Users -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text fs-4"><i class="bx bx-user"></i> 120</p>
                    </div>
                </div>
            </div>
            <!-- Card Total Obat -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Obat</h5>
                        <p class="card-text fs-4"><i class="bx bx-capsule"></i> 320</p>
                    </div>
                </div>
            </div>
            <!-- Card Total Transaksi -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Total Transaksi</h5>
                        <p class="card-text fs-4"><i class="bx bx-money"></i> 150</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Data Transaksi -->
        <h2 class="mt-5">Riwayat Transaksi</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Kasir</th>
                        <th>Kode Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Metode Pembayaran</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>OBT123</td>
                        <td>2</td>
                        <td>Rp 100,000</td>
                        <td>Transfer</td>
                        <td>2025-01-10 14:30:00</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>OBT456</td>
                        <td>1</td>
                        <td>Rp 50,000</td>
                        <td>Cash</td>
                        <td>2025-01-10 15:00:00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Assets/scripts/header.js"></script> <!-- Link ke file JS -->
</body>

</html>