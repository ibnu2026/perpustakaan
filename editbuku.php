<?php
require_once('buku.php');
$buku = new Buku();
$status = "";
$kode_buku=$_GET['kode_buku'];
$data = $buku->TampilByKode($kode_buku);
if (isset($_POST['ubah'])) {
    $kode_buku = $_GET['kode_buku'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $penerbit = $_POST['penerbit'];
    $id_kategori = $_POST['id_kategori'];
    $result = $buku->ubah($kode_buku, $judul, $penulis, $tahun_terbit, $penerbit, $id_kategori);

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
            <p class="col-md-8 fs-4">Sistem Manajemen Buku</p>
            <?php if (isset($message)) echo $message; ?>
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputKode_Buku1" class="form-label">Kode Buku</label>
                    <input type="number" class="form-control" id="kode_buku" name="kode_buku" aria-describedby="kode_bukuHelp" disabled
                    value="<?php echo $data['kode_buku']?>">
                    <div id="kode_bukuHelp" class="form-text">Isi Kode Buku dengan ISBN</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputJudul1" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" aria-describedby="judulHelp"
                    value="<?php echo $data['judul']?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPenulis1" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" name="penulis" aria-describedby="penulisHelp"
                    value="<?php echo $data['penulis']?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputTahunTerbit1" class="form-label">Tahun Terbit</label>
                    <input type="date" class="form-control" id="tahun_terbit" name="tahun_terbit" aria-describedby="tahun_terbitHelp"
                    value="<?php echo $data['tahun_terbit']?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPenerbit1" class="form-label">Penerbit</label>
                    <input type="text" class="form-control" id="penerbit" name="penerbit" aria-describedby="penerbitHelp"
                    value="<?php echo $data['penerbit']?>">
                </div>
                <div class="mb-3">
                    <label for="exampleSelectIdKategori1" class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select" aria-label="Default select example">
                        <option selected>Pilih Kategori</option>
                        <option value="000-100" <?php echo $data['id_kategori']=='000-100'? 'selected' : '';?>>Karya Umum</option>
                        <option value="101-200" <?php echo $data['id_kategori']=='101-200'? 'selected' : '';?>>Filsafat</option>
                        <option value="201-300" <?php echo $data['id_kategori']=='201-300'? 'selected' : '';?>>Keagamaan</option>
                        <option value="301-400" <?php echo $data['id_kategori']=='301-400'? 'selected' : '';?>>Ilmu Sosial</option>
                        <option value="401-500" <?php echo $data['id_kategori']=='401-500'? 'selected' : '';?>>Ilmu Murni</option>
                        <option value="501-600" <?php echo $data['id_kategori']=='501-600'? 'selected' : '';?>>Kesusastraan</option>
                    </select>
                </div>
                <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                <a href="databuku.php" class="btn btn-secondary">Batal</a>

            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>