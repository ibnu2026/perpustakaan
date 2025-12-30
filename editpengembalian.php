<?php
require_once('pengembalian.php');
$pengembalian = new Pengembalian();
$status = "";
$id_peminjaman = isset($_GET['id_peminjaman']) ? $_GET['id_peminjaman'] : '';
$data = $pengembalian->TampilById($id_peminjaman);

if (isset($_POST['ubah'])) {
    $id_peminjaman = $_GET['id_peminjaman'];
    $tanggal_pengembalian = isset($_POST['tanggal_pengembalian']) ? $_POST['tanggal_pengembalian'] : '';
    $status_peminjaman = isset($_POST['status']) ? $_POST['status'] : '';
    
    $result = $pengembalian->ubah($id_peminjaman, $tanggal_pengembalian, $status_peminjaman);
    
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
    <title>Edit Pengembalian - Sistem Manajemen Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php if ($status == "succes"): ?>
        <script>
            Swal.fire({
                title: "Data Pengembalian Berhasil Diubah!",
                icon: "success",
                draggable: true
            }).then(function() {
                window.location.href = 'datapengembalian.php';
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
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-2">
            <h1 class="display-5 fw-bold">@ Latee Perpus</h1>
            <p class="col-md-8 fs-4">Edit Pengembalian</p>
            <?php if (isset($data) && $data): ?>
            <form method="post">
                <div class="mb-3">
                    <label for="id_peminjaman" class="form-label">ID Peminjaman</label>
                    <input type="text" class="form-control" id="id_peminjaman" readonly
                    value="<?php echo $data['id_peminjaman']?>">
                </div>

                <div class="mb-3">
                    <label for="id_anggota" class="form-label">ID Anggota</label>
                    <input type="text" class="form-control" id="id_anggota" readonly
                    value="<?php echo $data['id_anggota']?>">
                </div>

                <div class="mb-3">
                    <label for="nama_anggota" class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" id="nama_anggota" readonly
                    value="<?php echo $data['nama_anggota']?>">
                </div>

                <div class="mb-3">
                    <label for="kode_buku" class="form-label">Kode Buku</label>
                    <input type="text" class="form-control" id="kode_buku" readonly
                    value="<?php echo $data['kode_buku']?>">
                </div>

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" id="judul" readonly
                    value="<?php echo $data['judul']?>">
                </div>

                <div class="mb-3">
                    <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                    <input type="date" class="form-control" id="tanggal_peminjaman" readonly
                    value="<?php echo $data['tanggal_peminjaman']?>">
                </div>

                <div class="mb-3">
                    <label for="tanggal_pengembalian_rencana" class="form-label">Tanggal Pengembalian (Rencana)</label>
                    <input type="date" class="form-control" id="tanggal_pengembalian_rencana" readonly
                    value="<?php echo $data['tanggal_pengembalian'] ? $data['tanggal_pengembalian'] : ''; ?>">
                </div>

                <div class="mb-3">
                    <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian (Aktual)</label>
                    <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" required
                    value="<?php echo $data['tanggal_pengembalian'] ? $data['tanggal_pengembalian'] : ''; ?>">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="dikembalikan" <?php echo $data['status'] == 'dikembalikan' ? 'selected' : ''; ?>>Dikembalikan</option>
                        <option value="hilang" <?php echo $data['status'] == 'hilang' ? 'selected' : ''; ?>>Hilang</option>
                    </select>
                </div>

                <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                <a href="datapengembalian.php" class="btn btn-secondary">Batal</a>
            </form>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Data pengembalian tidak ditemukan!
                </div>
                <a href="datapengembalian.php" class="btn btn-secondary">Kembali</a>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>
