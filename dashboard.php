<?php
session_start();

// Redirect ke login jika belum login
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once('buku.php');
require_once('pengunjung.php');
require_once('anggota.php');
require_once('peminjaman.php');
require_once('pengembalian.php');
require_once('pustakawan.php');

$pustakawan = new Pustakawan();
$userPustakawan = $pustakawan->cariByIdPustakawan($_SESSION['user_id']);

$buku = new Buku();
$pengunjung = new Pengunjung();
$anggota = new Anggota();
$peminjaman = new Peminjaman();
$pengembalian = new Pengembalian();

// Get counts
$dataBuku = $buku->tampilDataBuku();
$dataPengunjung = $pengunjung->tampilDataPengunjung();
$dataAnggota = $anggota->tampilDataAnggota();
$dataPeminjaman = $peminjaman->tampilDataPeminjaman();
$dataPengembalian = $pengembalian->tampilDataPengembalian();

$totalBuku = count($dataBuku);
$totalPengunjung = count($dataPengunjung);
$totalAnggota = count($dataAnggota);
$totalPeminjaman = count($dataPeminjaman);
$totalPengembalian = count($dataPengembalian);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Sistem Manajemen Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
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
                        <a class="nav-link" href="laporan.php">Laporan</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" onsubmit="searchDashboard(event)">
                    <input class="form-control me-2" type="search" id="searchInput" placeholder="Cari buku, anggota, peminjaman..." aria-label="Search">
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
                
                <script>
                function searchDashboard(event) {
                    event.preventDefault();
                    const query = document.getElementById('searchInput').value;
                    if (query.trim()) {
                        alert('Fitur pencarian global. Hasil akan ditampilkan di laporan.php dengan filter: ' + query);
                        window.location.href = 'laporan.php?search=' + encodeURIComponent(query);
                    }
                }
                </script>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-5">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="display-4 fw-bold">Dashboard</h1>
                <p class="text-muted">Selamat datang di Sistem Manajemen Perpustakaan</p>
            </div>
        </div>

        <!-- Stat Cards Row -->
        <div class="row mb-5">
            <!-- Data Buku Card -->
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card dashboard-card h-100" style="border-left-color: #0dcaf0;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Total Buku</p>
                                <h3 class="fw-bold mb-0"><?php echo $totalBuku; ?></h3>
                                <small class="text-muted">Koleksi Perpustakaan</small>
                            </div>
                            <div class="card-icon text-info">📚</div>
                        </div>
                        <a href="databuku.php" class="btn btn-sm btn-info mt-3">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <!-- Pengunjung Card -->
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card dashboard-card h-100" style="border-left-color: #20c997;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Total Pengunjung</p>
                                <h3 class="fw-bold mb-0"><?php echo $totalPengunjung; ?></h3>
                                <small class="text-muted">Data Lengkap</small>
                            </div>
                            <div class="card-icon text-success">👥</div>
                        </div>
                        <a href="datapengunjung.php" class="btn btn-sm btn-success mt-3">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <!-- Anggota Card -->
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card dashboard-card h-100" style="border-left-color: #ffc107;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Total Anggota</p>
                                <h3 class="fw-bold mb-0"><?php echo $totalAnggota; ?></h3>
                                <small class="text-muted">Member Aktif</small>
                            </div>
                            <div class="card-icon text-warning">👤</div>
                        </div>
                        <a href="dataanggota.php" class="btn btn-sm btn-warning mt-3">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <!-- Peminjaman Card -->
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card dashboard-card h-100" style="border-left-color: #0d6efd;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Total Peminjaman</p>
                                <h3 class="fw-bold mb-0"><?php echo $totalPeminjaman; ?></h3>
                                <small class="text-muted">Transaksi</small>
                            </div>
                            <div class="card-icon text-primary">📤</div>
                        </div>
                        <a href="datapeminjaman.php" class="btn btn-sm btn-primary mt-3">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <!-- Pengembalian Card -->
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card dashboard-card h-100" style="border-left-color: #fd7e14;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Total Pengembalian</p>
                                <h3 class="fw-bold mb-0"><?php echo $totalPengembalian; ?></h3>
                                <small class="text-muted">Transaksi</small>
                            </div>
                            <div class="card-icon text-danger">📥</div>
                        </div>
                        <a href="datapengembalian.php" class="btn btn-sm btn-danger mt-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Grafik Buku -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Grafik Data Buku</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartBuku"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Pengunjung -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Grafik Data Pengunjung</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartPengunjung"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Anggota -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Grafik Data Anggota</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartAnggota"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Peminjaman -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Grafik Peminjaman vs Pengembalian</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartPeminjamanPengembalian"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script>
        // Hitung kategori buku
        <?php
        $kategoriCount = [];
        foreach ($dataBuku as $item) {
            $kategori = $item['nama_kategori'] ?? 'Lainnya';
            $kategoriCount[$kategori] = ($kategoriCount[$kategori] ?? 0) + 1;
        }
        ?>
        
        // Grafik Data Buku per Kategori
        const ctxBuku = document.getElementById('chartBuku').getContext('2d');
        new Chart(ctxBuku, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_keys($kategoriCount)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($kategoriCount)); ?>,
                    backgroundColor: [
                        '#0dcaf0',
                        '#20c997',
                        '#ffc107',
                        '#fd7e14',
                        '#dc3545',
                        '#6f42c1'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Grafik Pengunjung per Rayon
        <?php
        $rayonCount = [];
        foreach ($dataPengunjung as $item) {
            $rayon = $item['rayon'] ?? 'Lainnya';
            $rayonCount[$rayon] = ($rayonCount[$rayon] ?? 0) + 1;
        }
        ?>
        
        const ctxPengunjung = document.getElementById('chartPengunjung').getContext('2d');
        new Chart(ctxPengunjung, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($rayonCount)); ?>,
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: <?php echo json_encode(array_values($rayonCount)); ?>,
                    backgroundColor: '#20c997'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafik Anggota per Kamar
        <?php
        $kamarCount = [];
        foreach ($dataAnggota as $item) {
            $kamar = $item['kamar'] ?? 'Lainnya';
            $kamarCount[$kamar] = ($kamarCount[$kamar] ?? 0) + 1;
        }
        // Limit to top 6
        $kamarCount = array_slice($kamarCount, 0, 6, true);
        ?>
        
        const ctxAnggota = document.getElementById('chartAnggota').getContext('2d');
        new Chart(ctxAnggota, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($kamarCount)); ?>,
                datasets: [{
                    label: 'Jumlah Anggota',
                    data: <?php echo json_encode(array_values($kamarCount)); ?>,
                    backgroundColor: '#ffc107'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafik Peminjaman vs Pengembalian
        <?php
        $peminjamanStatus = ['Dikembalikan' => 0, 'Belum Dikembalikan' => 0];
        foreach ($dataPeminjaman as $item) {
            if ($item['status'] === 'dikembalikan') {
                $peminjamanStatus['Dikembalikan']++;
            } else {
                $peminjamanStatus['Belum Dikembalikan']++;
            }
        }
        $pengembalianStatus = ['Dikembalikan' => 0, 'Hilang' => 0];
        foreach ($dataPengembalian as $item) {
            if ($item['status'] === 'dikembalikan') {
                $pengembalianStatus['Dikembalikan']++;
            } else {
                $pengembalianStatus['Hilang']++;
            }
        }
        ?>
        
        const ctxPeminjamanPengembalian = document.getElementById('chartPeminjamanPengembalian').getContext('2d');
        new Chart(ctxPeminjamanPengembalian, {
            type: 'bar',
            data: {
                labels: ['Dikembalikan', 'Belum Dikembalikan / Hilang'],
                datasets: [
                    {
                        label: 'Peminjaman',
                        data: [<?php echo $peminjamanStatus['Dikembalikan'] . ', ' . $peminjamanStatus['Belum Dikembalikan']; ?>],
                        backgroundColor: '#0d6efd'
                    },
                    {
                        label: 'Pengembalian',
                        data: [<?php echo $pengembalianStatus['Dikembalikan'] . ', ' . $pengembalianStatus['Hilang']; ?>],
                        backgroundColor: '#fd7e14'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
