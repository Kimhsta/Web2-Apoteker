<?php
// Include koneksi
include('../Config/koneksi.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputUsername = $_POST['username'];
        $inputPassword = $_POST['password'];

        // Query untuk mencocokkan username dan password di tabel kasir
        $query = "SELECT * FROM kasir WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $inputUsername);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        // Verifikasi password
        if ($user && $inputPassword === $user['password']) {
            session_start();
            $_SESSION['kasir_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];  // Simpan ID pengguna
            $_SESSION['user_name'] = $user['nama'];  // Simpan nama pengguna
            $_SESSION['user_profile'] = $user['profil'];  // Simpan profil pengguna

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #4c8bf5;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3b73d6;
        }

        .alert {
            margin-top: 15px;
        }

        footer {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4">
                    <div class="text-center mb-4 mt-4">
                        <img src="../Assets/img/LOGO.svg" alt="Logo" class="img-fluid" style="width: 150px;">
                    </div>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>
                    <footer class="text-center">
                        &copy; 2025 Apoteker Management System
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>