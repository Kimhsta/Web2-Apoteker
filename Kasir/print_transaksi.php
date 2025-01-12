<?php
include('../Config/koneksi.php');

// Ambil ID transaksi dari URL
$id_transaksi = $_GET['id'];

// Query untuk mengambil data transaksi berdasarkan ID
$query = $conn->prepare("
    SELECT t.id, t.id_kasir, t.kode_produk, t.jumlah, t.total_harga, t.metode_pembayaran, t.waktu, k.nama AS nama_kasir, o.nama AS nama_obat
    FROM transaksi t 
    JOIN kasir k ON t.id_kasir = k.id 
    JOIN obat o ON t.kode_produk = o.kode 
    WHERE t.id = ?
");
$query->bind_param("i", $id_transaksi);
$query->execute();
$result = $query->get_result();
$transaksi = $result->fetch_assoc();

if (!$transaksi) {
    echo "<p>Transaksi tidak ditemukan.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi Apotek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f8f9fa;
            }

            .container {
                width: 500px;
                margin-top: 20px;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                background-color: #fff;
            }

            .header {
                text-align: center;
                font-size: 30px;
                font-weight: bold;
                color: #007bff;
                margin-bottom: 15px;
            }

            .sub-header {
                text-align: center;
                font-size: 16px;
                margin-bottom: 20px;
                font-weight: bold;
            }

            .table {
                width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
            }

            .table td,
            .table th {
                padding: 10px;
                border: 1px solid #ddd;
            }

            .table th {
                background-color: #f2f2f2;
                font-size: 16px;
                text-align: left;
            }

            .table td {
                font-size: 16px;
                text-align: left;
            }

            .table td:last-child {
                text-align: right;
            }

            .footer {
                text-align: center;
                font-size: 14px;
                margin-top: 30px;
                color: #6c757d;
            }

            .no-print {
                display: none;
            }
        }

        .btn-print {
            margin: 20px auto;
            display: block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .logo {
            width: 120px;
            margin: 0 auto;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="path/to/logo.png" class="logo" alt="Logo">
            <p>Apotek Sehat</p>
        </div>

        <div class="sub-header">
            <p>Nota Transaksi Apotek</p>
            <p>Tanggal: <?= date("d-m-Y H:i", strtotime($transaksi['waktu'])); ?></p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $transaksi['nama_obat']; ?></td>
                    <td><?= $transaksi['jumlah']; ?></td>
                    <td>Rp. <?= number_format($transaksi['total_harga'], 2, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Metode Pembayaran: <?= $transaksi['metode_pembayaran']; ?></p>
            <p>Kasir: <?= $transaksi['nama_kasir']; ?></p>
            <p>Terima Kasih atas Kunjungan Anda!</p>
        </div>

        <div class="text-center no-print">
            <button class="btn-print" onclick="window.print()">Print Nota</button>
            <a href="index.php" class="btn btn-secondary">Kembali ke Daftar Transaksi</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>