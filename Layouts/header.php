<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="../Assets/css/header.css" rel="stylesheet"> <!-- Link ke file CSS -->
    <title>Responsive Sidebar</title>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar__header">
            <!-- Hamburger Menu -->
            <i class="bx bx-menu hamburger" onclick="toggleSidebar()"></i>
            <div class="sidebar__logo">
                <span class="sidebar__text">Apotik Waras</span>
            </div>
        </div>
        <a href="#" class="sidebar__link active">
            <i class="bx bx-home sidebar__icon"></i>
            <span class="sidebar__text">Dashboard</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-bar-chart-alt sidebar__icon"></i>
            <span class="sidebar__text">Reports</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-wallet sidebar__icon"></i>
            <span class="sidebar__text">Financials</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-folder sidebar__icon"></i>
            <span class="sidebar__text">Projects</span>
        </a>
        <a href="#" class="sidebar__link">
            <i class="bx bx-cog sidebar__icon"></i>
            <span class="sidebar__text">Settings</span>
        </a>
    </aside>

    <!-- Content -->
    <div class="content">
        <h1>Welcome to the Dashboard</h1>
        <p>Use the menu to navigate through different sections of the application.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Assets/scripts/header.js"></script> <!-- Link ke file JS -->
</body>
</html>
