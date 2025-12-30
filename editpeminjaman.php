<?php
require_once('peminjaman.php');
$peminjaman = new Peminjaman();
$status = "";
$id_peminjaman = isset($_GET['id_peminjaman']) ? $_GET['id_peminjaman'] : '';
$data = $peminjaman->TampilById($id_peminjaman);

if (isset($_POST['ubah'])) {
    $id_peminjaman = $_GET['id_peminjaman'];
    $id_anggota = isset($_POST['id_anggota']) ? $_POST['id_anggota'] : '';
    $kode_buku = isset($_POST['kode_buku']) ? $_POST['kode_buku'] : '';
    $tanggal_peminjaman = isset($_POST['tanggal_peminjaman']) ? $_POST['tanggal_peminjaman'] : '';
    
    // Update query yang hanya mengubah data peminjaman, bukan status/tanggal_pengembalian
    $query = "UPDATE peminjaman SET id_anggota='$id_anggota', kode_buku='$kode_buku', tanggal_peminjaman='$tanggal_peminjaman' WHERE id_peminjaman='$id_peminjaman'";
    $result = mysqli_query($peminjaman->getKoneksi(), $query);
    
    if ($result) {
        $status = "succes";
    } else {
        $status = "gagal";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Peminjaman - Sistem Manajemen Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php if ($status == "succes"): ?>
        <script>
            Swal.fire({
                title: "Data Berhasil Diubah!",
                icon: "success",
                draggable: true
            }).then(function() {
                window.location.href = 'datapeminjaman.php';
            });
        </script>
    <?php endif; ?>
    <?php if ($status == "gagal"): ?>
        <script>
            Swal.fire({
                icon: "error",
                title: "Data Gagal Diubah",
                text: "Isilah data sesuai ketentuan!",
            });
        </script>
    <?php endif; ?>

    <nav class="navbar navbar-expand bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">@ Latee Perpus</a>
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Dashboard</a>
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
                        <a class="nav-link active" aria-current="page" href="datapeminjaman.php">Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pengembalian</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-2">
            <h1 class="display-5 fw-bold">@ Latee Perpus</h1>
            <p class="col-md-8 fs-4">Edit Peminjaman</p>
            <?php if (isset($data) && $data): ?>
            <form method="post">
                <div class="mb-3">
                    <label for="id_peminjaman" class="form-label">ID Peminjaman</label>
                    <input type="text" class="form-control" id="id_peminjaman" readonly
                    value="<?php echo $data['id_peminjaman']?>">
                </div>

                <div class="mb-3">
                    <label for="id_anggota" class="form-label">ID Anggota</label>
                    <input type="text" class="form-control" id="id_anggota" name="id_anggota" required
                    value="<?php echo $data['id_anggota']?>">
                </div>

                <div class="mb-3">
                    <label for="nama_anggota" class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" id="nama_anggota" readonly
                    value="<?php echo $data['nama_anggota']?>">
                </div>

                <div class="mb-3">
                    <label for="kode_buku" class="form-label">Kode Buku</label>
                    <input type="text" class="form-control" id="kode_buku" name="kode_buku" required
                    value="<?php echo $data['kode_buku']?>">
                </div>

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" id="judul" readonly
                    value="<?php echo $data['judul']?>">
                </div>

                <div class="mb-3">
                    <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                    <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" required
                    value="<?php echo $data['tanggal_peminjaman']?>">
                </div>

                <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                <a href="datapeminjaman.php" class="btn btn-secondary">Batal</a>
            </form>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Data peminjaman tidak ditemukan!
                </div>
                <a href="datapeminjaman.php" class="btn btn-secondary">Kembali</a>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>
