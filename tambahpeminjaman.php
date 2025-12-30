<?php
require_once('peminjaman.php');
$peminjaman = new Peminjaman();
$status = "";

// Handle AJAX request untuk lookup buku
if(isset($_GET['action']) && $_GET['action'] == 'cariKodeBuku') {
    $kode_buku = isset($_GET['kode_buku']) ? $_GET['kode_buku'] : '';
    $result = $peminjaman->cariByKodeBuku($kode_buku);
    echo json_encode($result ? $result : ['error' => 'Buku tidak ditemukan']);
    exit;
}

// Handle AJAX request untuk lookup anggota
if(isset($_GET['action']) && $_GET['action'] == 'cariIdAnggota') {
    $id_anggota = isset($_GET['id_anggota']) ? $_GET['id_anggota'] : '';
    $result = $peminjaman->cariByIdAnggota($id_anggota);
    echo json_encode($result ? $result : ['error' => 'Anggota tidak ditemukan']);
    exit;
}

if(isset($_POST['simpan'])) {
    $id_peminjaman = isset($_POST['id_peminjaman']) ? $_POST['id_peminjaman'] : '';
    $id_anggota = isset($_POST['id_anggota']) ? $_POST['id_anggota'] : '';
    $id_pustakawan = '2026'; // Nanti dari session saat ada login
    $kode_buku = isset($_POST['kode_buku']) ? $_POST['kode_buku'] : '';
    $tanggal_peminjaman = isset($_POST['tanggal_peminjaman']) ? $_POST['tanggal_peminjaman'] : '';
    $status_peminjaman = isset($_POST['status']) ? $_POST['status'] : 'dipinjam';
    $result = $peminjaman->simpan($id_peminjaman, $id_anggota, $id_pustakawan, $kode_buku, $tanggal_peminjaman, $status_peminjaman);

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
            <p class="col-md-8 fs-4">Sistem Manajemen Peminjaman</p>
            <form method="post">
                <div class="mb-3">
                    <label for="id_peminjaman" class="form-label">ID Peminjaman</label>
                    <input type="text" class="form-control" id="id_peminjaman" name="id_peminjaman" required>
                </div>
                
                <div class="mb-3">
                    <label for="id_anggota" class="form-label">ID Anggota</label>
                    <input type="text" class="form-control" id="id_anggota" name="id_anggota" required>
                </div>
                
                <div class="mb-3">
                    <label for="nama_anggota" class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" id="nama_anggota" readonly>
                </div>

                <div class="mb-3">
                    <label for="kode_buku" class="form-label">Kode Buku</label>
                    <input type="text" class="form-control" id="kode_buku" name="kode_buku" required>
                </div>
                
                <div class="mb-3">
                    <label for="judul_buku" class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" id="judul_buku" readonly>
                </div>

                <div class="mb-3">
                    <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                    <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" required>
                </div>

                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="datapeminjaman.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script>
        // Lookup Kode Buku
        document.getElementById('kode_buku').addEventListener('blur', function() {
            const kodeBuku = this.value;
            if (kodeBuku) {
                fetch(`tambahpeminjaman.php?action=cariKodeBuku&kode_buku=${kodeBuku}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            document.getElementById('judul_buku').value = 'Buku tidak ditemukan';
                        } else {
                            document.getElementById('judul_buku').value = data.judul;
                        }
                    });
            }
        });

        // Lookup ID Anggota
        document.getElementById('id_anggota').addEventListener('blur', function() {
            const idAnggota = this.value;
            if (idAnggota) {
                fetch(`tambahpeminjaman.php?action=cariIdAnggota&id_anggota=${idAnggota}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            document.getElementById('nama_anggota').value = 'Anggota tidak ditemukan';
                        } else {
                            document.getElementById('nama_anggota').value = data.nama;
                        }
                    });
            }
        });

        // Otomatis hitung tanggal pengembalian (4 hari setelah peminjaman)
        document.getElementById('tanggal_peminjaman').addEventListener('change', function() {
            const tanggalPeminjaman = new Date(this.value);
            if (!isNaN(tanggalPeminjaman)) {
                // Tambah 4 hari
                tanggalPeminjaman.setDate(tanggalPeminjaman.getDate() + 4);
                // Format ke YYYY-MM-DD
                const tahun = tanggalPeminjaman.getFullYear();
                const bulan = String(tanggalPeminjaman.getMonth() + 1).padStart(2, '0');
                const hari = String(tanggalPeminjaman.getDate()).padStart(2, '0');
                const tanggalPengembalian = `${tahun}-${bulan}-${hari}`;
                document.getElementById('tanggal_pengembalian').value = tanggalPengembalian;
            }
        });
    </script>
</body>

</html>