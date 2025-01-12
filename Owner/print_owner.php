<?php
include('../Config/koneksi.php');

// Mengambil data owner dari database
$stmt = $conn->prepare("SELECT * FROM owners");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Owner</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Daftar Owner</h2>

        <button class="btn btn-primary no-print" onclick="window.print()">Cetak</button>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Foto Profil</th>
                    <th>No. Telepon</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                while ($owner = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($owner['nama']); ?></td>
                        <td><?php echo htmlspecialchars($owner['username']); ?></td>
                        <td><img src="../Assets/uploads/<?php echo $owner['profil']; ?>" alt="Foto Profil" width="100"></td>
                        <td><?php echo htmlspecialchars($owner['no_hp']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$stmt->close();
?>