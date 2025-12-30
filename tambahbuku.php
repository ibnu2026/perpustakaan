<?php
require_once('buku.php');
$buku = new Buku();
$status = "";
if(isset($_POST['simpan'])) {
    $kode_buku = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $penerbit = $_POST['penerbit'];
    $id_kategori = $_POST['id_kategori'];
    $result = $buku->simpan($kode_buku, $judul, $penulis, $tahun_terbit, $penerbit, $id_kategori);

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
            <p class="col-md-8 fs-4">Sistem Manajemen Buku</p>
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputKode_Buku1" class="form-label">Kode Buku</label>
                    <input type="number" class="form-control" id="kode_buku" name="kode_buku" aria-describedby="kode_bukuHelp">
                    <div id="kode_bukuHelp" class="form-text">Isi Kode Buku dengan ISBN</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputJudul1" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" aria-describedby="judulHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPenulis1" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" name="penulis" aria-describedby="penulisHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputTahunTerbit1" class="form-label">Tahun Terbit</label>
                    <input type="date" class="form-control" id="tahun_terbit" name="tahun_terbit" aria-describedby="tahun_terbitHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPenerbit1" class="form-label">Penerbit</label>
                    <input type="text" class="form-control" id="penerbit" name="penerbit" aria-describedby="penerbitHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleSelectIdKategori1" class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select" aria-label="Default select example">
                        <option selected>Pilih Kategori</option>
                        <option value="000-100">Karya Umum</option>
                        <option value="101-200">Filsafat</option>
                        <option value="201-300">Keagamaan</option>
                        <option value="301-400">Ilmu Sosial</option>
                        <option value="401-500">Ilmu Murni</option>
                        <option value="501-600">Kesusastraan</option>
                    </select>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="databuku.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>