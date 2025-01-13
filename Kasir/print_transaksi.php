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
    WHERE t.id = ?");
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
    <title>Cetak Nota Transaksi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

        :root {
            --primary-color: #3498db;
            --secondary-color: #f1f8ff;
            --accent-color: #2ecc71;
            --text-color: #2c3e50;
            --border-color: #bdc3c7;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ecf0f1;
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background-color: #fff;
            padding: 20mm;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary-color);
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            max-width: 60px;
            height: auto;
            margin-right: 20px;
        }

        .hospital-info {
            font-size: 0.9em;
        }

        .hospital-info h1 {
            font-size: 1.5em;
            margin-bottom: 5px;
        }

        .nota-info {
            text-align: right;
        }

        h1,
        h2 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .info-section {
            background-color: var(--secondary-color);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .info-item {
            display: flex;
            align-items: baseline;
        }

        .info-item strong {
            min-width: 120px;
            margin-right: 10px;
            color: var(--primary-color);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 15px;
            border-radius: 8px;
            overflow: hidden;
            font-size: 0.9em;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8em;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .total-section {
            margin-top: 20px;
            text-align: right;
            font-size: 0.9em;
        }

        .total-item {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 5px;
        }

        .total-item strong {
            margin-right: 20px;
            min-width: 150px;
            color: var(--primary-color);
        }

        .grand-total {
            font-size: 1.2em;
            color: var(--accent-color);
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid var(--accent-color);
        }

        @media print {
            body {
                background-color: #fff;
            }

            .container {
                box-shadow: none;
                padding: 10mm;
            }

            @page {
                size: A4;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="logo-container">
                <img src="../logo.png" alt="Logo Apotek" class="logo">
                <div class="hospital-info">
                    <h1>Apotek Sehat</h1>
                    <p>Jl. Contoh No. 123, Kota</p>
                    <p>Telp: (021) 1234-5678</p>
                </div>
            </div>
            <div class="nota-info">
                <h2>Nota Transaksi</h2>
                <p>Tanggal: <?= date('d/m/Y', strtotime($transaksi['waktu'])); ?></p>
            </div>
        </header>

        <h2>Informasi Transaksi</h2>
        <div class="info-section">
            <div class="info-item"><strong>Kasir:</strong> <span><?= $transaksi['nama_kasir']; ?></span></div>
            <div class="info-item"><strong>Metode:</strong> <span><?= $transaksi['metode_pembayaran']; ?></span></div>
        </div>

        <table>
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

        <div class="total-section">
            <div class="total-item">
                <strong>Total:</strong> Rp. <?= number_format($transaksi['total_harga'], 2, ',', '.'); ?>
            </div>
        </div>
    </div>
</body>

</html>