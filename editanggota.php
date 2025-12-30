<?php
require_once('anggota.php');
$anggota = new Anggota();
$status = "";
$id_anggota=$_GET['id_anggota'];
$data = $anggota->TampilById($id_anggota);
if (isset($_POST['ubah'])) {
    $id_anggota = $_GET['id_anggota'];
    $nama = $_POST['nama'];
    $kamar = $_POST['kamar'];
    $alamat = $_POST['alamat'];
    $result = $anggota->ubah($id_anggota, $nama, $kamar, $alamat);

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
            <h1 class="display-5 fw-bold">@ Latee Library</h1>
            <p class="col-md-8 fs-4">Sistem Manajemen Anggota</p>
            <?php if (isset($message)) echo $message; ?>
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputID_Anggota1" class="form-label">ID Anggota</label>
                    <input type="number" class="form-control" id="id_anggota" name="id_anggota" aria-describedby="id_anggotaHelp" disabled
                    value="<?php echo $data['id_anggota']?>">
                    <div id="id_anggotaHelp" class="form-text">Isi ID Anggota dengan Nomor Anggota</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputNama1" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" aria-describedby="namaHelp"
                    value="<?php echo $data['nama']?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputKamar1" class="form-label">Kamar</label>
                    <input type="text" class="form-control" id="kamar" name="kamar" aria-describedby="kamarHelp"
                    value="<?php echo $data['kamar']?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputAlamat1" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" aria-describedby="alamatHelp"
                    value="<?php echo $data['alamat']?>">
                </div>
                <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                <a href="dataanggota.php" class="btn btn-secondary">Batal</a>

            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>