<?php
// File: dashboard.php

// Pastikan Anda sudah menyertakan koneksi ke database dan file konfigurasi di sini
include 'db_connection.php';
include 'header.php'; // Header untuk template Bootstrap
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
                            <span data-feather="home"></span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">
                            <span data-feather="users"></span>
                            Manajemen Pengguna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_rooms.php">
                            <span data-feather="map"></span>
                            Manajemen Ruangan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_equipment.php">
                            <span data-feather="cpu"></span>
                            Manajemen Peralatan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_categories.php">
                            <span data-feather="layers"></span>
                            Manajemen Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_suppliers.php">
                            <span data-feather="truck"></span>
                            Manajemen Supplier
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_loans.php">
                            <span data-feather="file-text"></span>
                            Manajemen Peminjaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_activities.php">
                            <span data-feather="activity"></span>
                            Aktivitas Pengguna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reports.php">
                            <span data-feather="bar-chart-2"></span>
                            Laporan
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Pengguna</h5>
                            <p class="card-text">
                                <?php
                                $result = $conn->query("SELECT COUNT(*) AS total FROM users");
                                $data = $result->fetch_assoc();
                                echo $data['total'];
                                ?>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<?php
include 'footer.php'; // Footer untuk template Bootstrap
?>