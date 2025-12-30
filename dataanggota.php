<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

require_once('anggota.php');require_once('pustakawan.php');

$pustakawan = new Pustakawan();
$userPustakawan = $pustakawan->cariByIdPustakawan($_SESSION['user_id']);$anggota = new Anggota();
$status = "";
if (isset($_GET['id_anggota'])) {
    $id_anggota = $_GET['id_anggota'];
    $result = $anggota->hapus($id_anggota);
}
$isiData = $anggota->tampilDataAnggota();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Manajemen Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
                        <a class="nav-link active" aria-current="page" href="dataanggota.php">Anggota</a>
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
                <form class="d-flex" role="search" onsubmit="searchAnggota(event)">
                    <input class="form-control me-2" type="search" id="searchInput" placeholder="Cari anggota..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Cari</button>
                </form>
                <script>
                function searchAnggota(event) {
                    event.preventDefault();
                    const query = document.getElementById('searchInput').value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(query) ? '' : 'none';
                    });
                }
                </script>
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
            <p class="col-md-8 fs-4">Sistem Manajemen Anggota</p>
            <a href="tambahanggota.php" class="btn btn-primary">Tambah</button>
                <a href="dataanggota.php" class="btn btn-secondary ms-2">Refresh</a>
                <table class="table table-striped table-hover mt-4">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ID Anggota</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kamar</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($isiData as $data): ?><!-- Memulai perulangan -->
                            <tr>
                                <th scope="row"><?php echo $no++ ?></th>
                                <td><?php echo $data['id_anggota'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['kamar'] ?></td>
                                <td><?= $data['alamat'] ?></td>
                                <td>
                                    <a href="editanggota.php?id_anggota=<?php echo $data['id_anggota'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="dataanggota.php?id_anggota=<?php echo $data['id_anggota'] ?>" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data <?php echo $data['nama'] ?>?')" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach ?><!-- Mengakhiri perulangan -->
                    </tbody>
                </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>