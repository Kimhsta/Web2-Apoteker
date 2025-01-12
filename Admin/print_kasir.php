<?php
// Include file koneksi ke database
include('../Config/koneksi.php');

// Periksa apakah ID kasir dikirim melalui URL
if (isset($_GET['id_kasir'])) {
    $id_kasir = $_GET['id_kasir'];

    // Query untuk mengambil data kasir berdasarkan ID
    $query = $conn->prepare("SELECT * FROM kasir WHERE id = ?");
    $query->bind_param("i", $id_kasir);
    $query->execute();
    $result = $query->get_result();

    // Periksa apakah data ditemukan
    if ($result->num_rows > 0) {
        $kasir = $result->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cetak Data Kasir</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f9f9f9;
                    color: #333;
                }

                .container {
                    width: 90%;
                    max-width: 800px;
                    margin: 30px auto;
                    background: #fff;
                    border-radius: 10px;
                    padding: 20px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                }

                h1 {
                    text-align: center;
                    font-size: 24px;
                    margin-bottom: 20px;
                    color: #555;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }

                th,
                td {
                    text-align: left;
                    padding: 10px;
                    border: 1px solid #ddd;
                }

                th {
                    background-color: #f0f0f0;
                    font-weight: bold;
                }

                .profile {
                    text-align: center;
                    margin: 20px 0;
                }

                .profile img {
                    width: 120px;
                    height: 120px;
                    object-fit: cover;
                    border-radius: 50%;
                    border: 2px solid #ddd;
                }

                .btn-print {
                    display: block;
                    width: 200px;
                    margin: 20px auto;
                    padding: 10px;
                    text-align: center;
                    background-color: #4CAF50;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                }

                .btn-print:hover {
                    background-color: #45a049;
                }

                /* CSS untuk media cetak */
                @media print {
                    .btn-print {
                        display: none;
                    }
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h1>Data Kasir</h1>

                <div class="profile">
                    <img src="../Assets/uploads/<?= $kasir['profil']; ?>" alt="Profil Kasir">
                </div>

                <table>
                    <tr>
                        <th>ID</th>
                        <td><?= $kasir['id']; ?></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><?= $kasir['nama']; ?></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><?= $kasir['username']; ?></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><?= $kasir['password']; ?></td>
                    </tr>
                    <tr>
                        <th>No. Telp</th>
                        <td><?= $kasir['no_hp']; ?></td>
                    </tr>
                </table>

                <button class="btn-print" onclick="window.print()">Cetak</button>
            </div>
        </body>

        </html>
<?php
    } else {
        echo "<p>Data kasir tidak ditemukan.</p>";
    }
} else {
    echo "<p>ID kasir tidak ditemukan.</p>";
}
?>