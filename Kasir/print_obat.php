<?php
include('../Config/koneksi.php');

// Validasi kode obat
if (!isset($_GET['kode_obat']) || empty($_GET['kode_obat'])) {
    echo "<script>alert('Kode obat tidak ditemukan.'); window.close();</script>";
    exit;
}

$kode_obat = $_GET['kode_obat'];

// Ambil data obat berdasarkan kode
$query = $conn->prepare("SELECT * FROM obat WHERE kode = ?");
$query->bind_param("s", $kode_obat);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Data obat tidak ditemukan.'); window.close();</script>";
    exit;
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Obat - <?= htmlspecialchars($data['nama']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9em;
            color: #555;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Detail Obat</h1>
        <table>
            <tr>
                <th>Kode</th>
                <td><?= htmlspecialchars($data['kode']); ?></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td><?= htmlspecialchars($data['nama']); ?></td>
            </tr>
            <tr>
                <th>Gambar</th>
                <td class="text-center">
                    <img src="../Assets/uploads/<?= htmlspecialchars($data['gambar']); ?>" alt="Gambar Obat" style="width: 100px; height: 100px; object-fit: cover;">
                </td>
            </tr>
            <tr>
                <th>Stok</th>
                <td><?= htmlspecialchars($data['stok']); ?></td>
            </tr>
            <tr>
                <th>Jenis Obat</th>
                <td><?= htmlspecialchars($data['jenis_obat']); ?></td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td><?= htmlspecialchars($data['kategori']); ?></td>
            </tr>
            <tr>
                <th>Harga</th>
                <td class="text-right"><?= "Rp. " . number_format($data['harga'], 2, ',', '.'); ?></td>
            </tr>
        </table>
        <div class="footer">
            <p>Dicetak pada: <?= date('d-m-Y H:i:s'); ?></p>
            <button class="btn-print" onclick="window.print()">Cetak</button>
            <button class="btn-print" onclick="window.close()">Tutup</button>
        </div>
    </div>
</body>

</html>