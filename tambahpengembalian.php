<?php
require_once('pengembalian.php');
$pengembalian = new Pengembalian();
$status = "";

// Handle AJAX request untuk lookup id_peminjaman
if(isset($_GET['action']) && $_GET['action'] == 'cariIdPeminjaman') {
    $id_peminjaman = isset($_GET['id_peminjaman']) ? $_GET['id_peminjaman'] : '';
    $result = $pengembalian->cariByIdPeminjaman($id_peminjaman);
    echo json_encode($result ? $result : ['error' => 'Peminjaman tidak ditemukan']);
    exit;
}

if(isset($_POST['simpan'])) {
    $id_peminjaman = isset($_POST['id_peminjaman']) ? $_POST['id_peminjaman'] : '';
    $tanggal_pengembalian = isset($_POST['tanggal_pengembalian']) ? $_POST['tanggal_pengembalian'] : '';
    $status_peminjaman = isset($_POST['status']) ? $_POST['status'] : 'dikembalikan';
    
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
    <title>Sistem Manajemen Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php if ($status == "succes"): ?>
        <script>
            Swal.fire({
                title: "Data Pengembalian Berhasil Disimpan!",
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
                title: "Data Gagal Disimpan",
                text: "Isilah data sesuai ketentuan!",
            });
        </script>
    <?php endif; ?>
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-2">
            <h1 class="display-5 fw-bold">@ Latee Perpus</h1>
            <p class="col-md-8 fs-4">Sistem Manajemen Pengembalian Buku</p>
            <form method="post">
                <div class="mb-3">
                    <label for="id_peminjaman" class="form-label">ID Peminjaman</label>
                    <input type="text" class="form-control" id="id_peminjaman" name="id_peminjaman" required>
                </div>
                
                <div class="mb-3">
                    <label for="id_anggota" class="form-label">ID Anggota</label>
                    <input type="text" class="form-control" id="id_anggota" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_anggota" class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" id="nama_anggota" readonly>
                </div>

                <div class="mb-3">
                    <label for="kamar" class="form-label">Kamar</label>
                    <input type="text" class="form-control" id="kamar" readonly>
                </div>

                <div class="mb-3">
                    <label for="kode_buku" class="form-label">Kode Buku</label>
                    <input type="text" class="form-control" id="kode_buku" readonly>
                </div>

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" id="judul" readonly>
                </div>

                <div class="mb-3">
                    <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                    <input type="date" class="form-control" id="tanggal_peminjaman" readonly>
                </div>

                <div class="mb-3">
                    <label for="tanggal_pengembalian_rencana" class="form-label">Tanggal Pengembalian (Rencana)</label>
                    <input type="date" class="form-control" id="tanggal_pengembalian_rencana" readonly>
                </div>

                <div class="mb-3">
                    <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian (Aktual)</label>
                    <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="dikembalikan">Dikembalikan</option>
                        <option value="hilang">Hilang</option>
                    </select>
                </div>

                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="datapengembalian.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script>
        // Lookup ID Peminjaman
        document.getElementById('id_peminjaman').addEventListener('blur', function() {
            const idPeminjaman = this.value;
            if (idPeminjaman) {
                fetch(`tambahpengembalian.php?action=cariIdPeminjaman&id_peminjaman=${idPeminjaman}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert('Peminjaman tidak ditemukan');
                            document.getElementById('id_anggota').value = '';
                            document.getElementById('nama_anggota').value = '';
                            document.getElementById('kamar').value = '';
                            document.getElementById('kode_buku').value = '';
                            document.getElementById('judul').value = '';
                            document.getElementById('tanggal_peminjaman').value = '';
                            document.getElementById('tanggal_pengembalian_rencana').value = '';
                        } else {
                            document.getElementById('id_anggota').value = data.id_anggota;
                            document.getElementById('nama_anggota').value = data.nama_anggota;
                            document.getElementById('kamar').value = data.kamar;
                            document.getElementById('kode_buku').value = data.kode_buku;
                            document.getElementById('judul').value = data.judul;
                            document.getElementById('tanggal_peminjaman').value = data.tanggal_peminjaman;
                            document.getElementById('tanggal_pengembalian_rencana').value = data.tanggal_pengembalian;
                        }
                    });
            }
        });
    </script>
</body>

</html>
