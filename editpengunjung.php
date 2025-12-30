<?php
require_once('pengunjung.php');
$pengunjung = new Pengunjung();
$status = "";
$nis=$_GET['nis'];
$data = $pengunjung->TampilBynis($nis);
if (isset($_POST['ubah'])) {
    $nis = $_GET['nis'];
    $nama = $_POST['nama'];
    $rayon = $_POST['rayon'];
    $kamar = $_POST['kamar'];
    $result = $pengunjung->ubah($nis, $nama, $rayon, $kamar);

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
            <p class="col-md-8 fs-4">Sistem Manajemen Pengunjung</p>
            <?php if (isset($message)) echo $message; ?>
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputNIS1" class="form-label">NIS</label>
                    <input type="number" class="form-control" id="nis" name="nis" aria-describedby="nisHelp" disabled
                    value="<?php echo $data['nis']?>">
                    <div id="nisHelp" class="form-text">Isi NIS dengan Nomor Induk Santri</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputNama1" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" aria-describedby="namaHelp"
                    value="<?php echo $data['nama']?>">
                </div>
                <div class="mb-3">
                    <label for="exampleSelectRayon1" class="form-label">Rayon</label>
                    <select name="rayon" class="form-select" aria-label="Default select example">
                        <option selected>Pilih Rayon</option>
                        <option value="Asy-Syafi'ie" <?php echo $data['rayon']=="Asy-Syafi'ie"? 'selected' : '';?>>Asy-Syafi'ie</option>
                        <option value="Al-Bukhori" <?php echo $data['rayon']=='Al-Bukhori'? 'selected' : '';?>>Al-Bukhori</option>
                        <option value="Al-Ghazali" <?php echo $data['rayon']=='Al-Ghazali'? 'selected' : '';?>>Al-Ghazali</option>
                        <option value="LSB" <?php echo $data['rayon']=='LSB'? 'selected' : '';?>>LSB</option>
                        <option value="LSM" <?php echo $data['rayon']=='LSM'? 'selected' : '';?>>LSM</option>
                        <option value="LTQ" <?php echo $data['rayon']=='LTQ'? 'selected' : '';?>>LTQ</option>
                        <option value="EAL" <?php echo $data['rayon']=='EAL'? 'selected' : '';?>>EAL</option>
                        <option value="DALFIS" <?php echo $data['rayon']=='DALFIS'? 'selected' : '';?>>DALFIS</option>
                        <option value="KBS" <?php echo $data['rayon']=='KBS'? 'selected' : '';?>>KBS</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleInputAlamat1" class="form-label">Kamar</label>
                    <input type="text" class="form-control" id="kamar" name="kamar" aria-describedby="kamarHelp"
                    value="<?php echo $data['kamar']?>">
                </div>
                <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                <a href="datapengunjung.php" class="btn btn-secondary">Batal</a>

            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>