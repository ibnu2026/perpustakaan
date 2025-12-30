<?php
session_start();

// Redirect ke login jika belum login
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once('pustakawan.php');
$pustakawan = new Pustakawan();

$message = '';
$messageType = '';

// Ambil data pustakawan dari database
$userPustakawan = $pustakawan->cariByIdPustakawan($_SESSION['user_id']);

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    
    // Validasi file
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize = 2 * 1024 * 1024; // 2MB
    
    if (!in_array($file['type'], $allowedTypes)) {
        $message = 'Hanya file gambar yang diizinkan (JPG, PNG, GIF, WebP)!';
        $messageType = 'danger';
    } elseif ($file['size'] > $maxSize) {
        $message = 'Ukuran file tidak boleh lebih dari 2MB!';
        $messageType = 'danger';
    } elseif ($file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Buat nama file unik
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = $_SESSION['user_id'] . '_' . time() . '.' . $fileExt;
        $uploadPath = $uploadDir . $newFileName;
        
        // Hapus avatar lama jika ada
        if (!empty($userPustakawan['avatar']) && file_exists($userPustakawan['avatar'])) {
            unlink($userPustakawan['avatar']);
        }
        
        // Upload file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Update database
            if ($pustakawan->updateAvatar($_SESSION['user_id'], $uploadPath)) {
                $message = 'Foto profil berhasil diperbarui!';
                $messageType = 'success';
                // Refresh data
                $userPustakawan = $pustakawan->cariByIdPustakawan($_SESSION['user_id']);
            } else {
                $message = 'Gagal menyimpan data ke database!';
                $messageType = 'danger';
                unlink($uploadPath);
            }
        } else {
            $message = 'Gagal mengunggah file!';
            $messageType = 'danger';
        }
    } else {
        $message = 'Terjadi kesalahan saat mengunggah file!';
        $messageType = 'danger';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil - Sistem Manajemen Perpustakaan</title>
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
        .avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 3rem;
            margin: 0 auto 20px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .avatar-large:hover {
            opacity: 0.9;
        }
        .avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        #avatarInput {
            display: none;
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
                        <a class="nav-link" href="dataanggota.php">Anggota</a>
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
            </div>
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
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Profil</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="text-center mb-4">
                                <div class="avatar-large" onclick="document.getElementById('avatarInput').click()" title="Klik untuk upload foto">
                                    <?php if (!empty($userPustakawan['avatar']) && file_exists($userPustakawan['avatar'])): ?>
                                        <img src="<?php echo htmlspecialchars($userPustakawan['avatar']); ?>" alt="Avatar">
                                    <?php else: ?>
                                        <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                                    <?php endif; ?>
                                </div>
                                <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;">
                            </div>

                            <div class="mb-3">
                                <label for="id_pustakawan" class="form-label">ID Pustakawan</label>
                                <input type="text" class="form-control" id="id_pustakawan" value="<?php echo htmlspecialchars($userPustakawan['id_pustakawan'] ?? ''); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($userPustakawan['nama'] ?? ''); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" readonly><?php echo htmlspecialchars($userPustakawan['alamat'] ?? ''); ?></textarea>
                            </div>

                            <div id="uploadInfo" style="display: none;" class="alert alert-info mb-3">
                                File dipilih: <strong id="fileName"></strong><br>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">Simpan Foto</button>
                                <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="document.getElementById('avatarInput').value = ''; document.getElementById('uploadInfo').style.display = 'none';">Batal</button>
                            </div>

                            <div class="mb-3 text-center">
                                <button type="button" class="btn btn-secondary" onclick="history.back()">Kembali</button>
                                <a href="logout.php" class="btn btn-danger">Logout</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    
    <script>
        // Handle avatar file selection
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Hanya file gambar yang diizinkan (JPG, PNG, GIF, WebP)!');
                    this.value = '';
                    document.getElementById('uploadInfo').style.display = 'none';
                    return;
                }
                
                // Validasi ukuran
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('Ukuran file tidak boleh lebih dari 2MB!');
                    this.value = '';
                    document.getElementById('uploadInfo').style.display = 'none';
                    return;
                }
                
                // Tampilkan info file
                document.getElementById('fileName').textContent = file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)';
                document.getElementById('uploadInfo').style.display = 'block';
                
                // Preview gambar
                const reader = new FileReader();
                reader.onload = function(event) {
                    const avatarDiv = document.querySelector('.avatar-large');
                    avatarDiv.innerHTML = '<img src="' + event.target.result + '" alt="Preview">';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
