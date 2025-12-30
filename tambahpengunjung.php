<?php
require_once('pengunjung.php');
$pengunjung = new Pengunjung();
$status = "";
if(isset($_POST['simpan'])) {
    $nis = $_POST['nis'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $rayon = $_POST['rayon'] ?? '';
    $kamar = $_POST['kamar'] ?? '';
    $result = $pengunjung->simpan($nis, $nama, $rayon, $kamar);

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
    <title>Sistem Manajemen Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php if ($status == "succes"): ?>
        <script>
            Swal.fire({
                title: "Data Berhasil Disimpan!",
                icon: "success",
                draggable: true
            });
        </script>
    <?php endif; ?>
    <?php if ($status == "gagal"): ?>
        <script>
            Swal.fire({
                icon: "error",
                title: "Data Gagal Disimpan",
                text: "Isilah data sesuai ketentuan!",
            });
        </script>
    <?php endif; ?>
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-2">
            <h1 class="display-5 fw-bold">@ Latee Perpus</h1>
            <p class="col-md-8 fs-4">Sistem Manajemen Pengunjung</p>
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputNIS1" class="form-label">NIS</label>
                    <input type="number" class="form-control" id="nis" name="nis" aria-describedby="nisHelp">
                    <div id="nisHelp" class="form-text">Isi NIS dengan Nomor Induk Santri</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputNama1" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" aria-describedby="namaHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleSelectRayon1" class="form-label">Rayon</label>
                    <select name="rayon" class="form-select" aria-label="Default select example">
                        <option selected>Pilih Rayon</option>
                        <option value="Asy-Syafi'ie">Asy-Syafi'ie</option>
                        <option value="Al-Bukhori">Al-Bukhori</option>
                        <option value="Al-Ghazali">Al-Ghazali</option>
                        <option value="LSB">LSB</option>
                        <option value="LSM">LSM</option>
                        <option value="LTQ">LTQ</option>
                        <option value="EAL">EAL</option>
                        <option value="DALFIS">DALFIS</option>
                        <option value="KBS">KBS</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleInputKamar1" class="form-label">Kamar</label>
                    <input type="text" class="form-control" id="kamar" name="kamar" aria-describedby="kamarHelp">
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="datapengunjung.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>