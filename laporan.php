<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

require_once('buku.php');
require_once('pengunjung.php');
require_once('anggota.php');
require_once('peminjaman.php');
require_once('pengembalian.php');
require_once('pustakawan.php');

$buku = new Buku();
$pengunjung = new Pengunjung();
$anggota = new Anggota();
$peminjaman = new Peminjaman();
$pengembalian = new Pengembalian();
$pustakawan = new Pustakawan();
$userPustakawan = $pustakawan->cariByIdPustakawan($_SESSION['user_id']);


$dataBuku = $buku->tampilDataBuku();
$dataPengunjung = $pengunjung->tampilDataPengunjung();
$dataAnggota = $anggota->tampilDataAnggota();
$dataPeminjaman = $peminjaman->tampilDataPeminjaman();
$dataPengembalian = $pengembalian->tampilDataPengembalian();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan - Sistem Manajemen Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar > div {
            display: flex;
            gap: 40px;
            align-items: center;
        }
        form.d-flex {
            margin-right: 40px;
        }
        .avatar-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-left: 0px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">@ Latee Perpus</a>
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="databuku.php">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dataanggota.php">Anggota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="datapengunjung.php">Pengunjung</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="datapeminjaman.php">Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="datapengembalian.php">Pengembalian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="laporan.php">Laporan</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" onsubmit="searchLaporan(event)">
                    <input class="form-control me-2" type="search" id="searchInput" placeholder="Cari semua data..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Cari</button>
                </form>
                <!-- Avatar Dropdown -->
                <div class="dropdown">
                    <div class="avatar-placeholder" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (!empty($userPustakawan['avatar']) && file_exists($userPustakawan['avatar'])): ?>
                            <img src="<?php echo htmlspecialchars($userPustakawan['avatar']); ?>" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                        <?php else: ?>
                            <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                        <?php endif; ?>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person"></i> Edit Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-2">
            <h1 class="display-5 fw-bold">@ Latee Perpus</h1>
            <p class="col-md-8 fs-4">Laporan & Download Data</p>

            <!-- Download Cards Section -->
            <h3 class="mt-5 mb-4">Download Data Dalam Format Excel</h3>
            <div class="row g-3 mb-5">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-book fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Data Buku</h5>
                            <a href="export.php?type=buku" class="btn btn-primary btn-sm">
                                <i class="fas fa-download"></i> Download Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Data Pengunjung</h5>
                            <a href="export.php?type=pengunjung" class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Download Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-user-tie fa-3x text-info mb-3"></i>
                            <h5 class="card-title">Data Anggota</h5>
                            <a href="export.php?type=anggota" class="btn btn-info btn-sm">
                                <i class="fas fa-download"></i> Download Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-share-alt fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Data Peminjaman</h5>
                            <a href="export.php?type=peminjaman" class="btn btn-warning btn-sm">
                                <i class="fas fa-download"></i> Download Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-undo fa-3x text-danger mb-3"></i>
                            <h5 class="card-title">Data Pengembalian</h5>
                            <a href="export.php?type=pengembalian" class="btn btn-danger btn-sm">
                                <i class="fas fa-download"></i> Download Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Tables Section (Optional) -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script>
    function searchLaporan(event) {
        event.preventDefault();
        const query = document.getElementById('searchInput').value.toLowerCase();
        
        if (query.trim()) {
            alert('Pencarian: ' + query);
        }
    }
    </script>
</body>

</html>
