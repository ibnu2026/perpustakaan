<?php
require_once('buku.php');
require_once('pengunjung.php');
require_once('anggota.php');
require_once('peminjaman.php');
require_once('pengembalian.php');

$type = isset($_GET['type']) ? $_GET['type'] : '';

function exportToExcel($headers, $data, $filename) {
    // Set headers untuk download file Excel (HTML format yang dikenali Excel)
    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Create HTML table format yang Excel bisa baca dengan baik
    $output = "<table>\n<tr>";
    
    // Add headers
    foreach ($headers as $header) {
        $output .= "<td>" . htmlspecialchars($header) . "</td>";
    }
    $output .= "</tr>\n";
    
    // Add data rows
    foreach ($data as $row) {
        $output .= "<tr>";
        foreach ($row as $val) {
            $output .= "<td>" . htmlspecialchars($val) . "</td>";
        }
        $output .= "</tr>\n";
    }
    $output .= "</table>";
    
    echo $output;
    exit;
}

if ($type == 'buku') {
    $buku = new Buku();
    $dataBuku = $buku->tampilDataBuku();
    
    $headers = ['Kode Buku', 'Judul', 'Penulis', 'Penerbit', 'Tahun Terbit', 'Kategori'];
    $data = [];
    
    foreach ($dataBuku as $row) {
        $data[] = [
            $row['kode_buku'] ?? '',
            $row['judul'] ?? '',
            $row['penulis'] ?? '',
            $row['penerbit'] ?? '',
            $row['tahun_terbit'] ?? '',
            $row['nama_kategori'] ?? ''
        ];
    }
    
    exportToExcel($headers, $data, 'Data_Buku_' . date('Y-m-d_H-i-s'));
}

elseif ($type == 'pengunjung') {
    $pengunjung = new Pengunjung();
    $dataPengunjung = $pengunjung->tampilDataPengunjung();
    
    $headers = ['NIS', 'Nama', 'Rayon', 'Kamar'];
    $data = [];
    
    foreach ($dataPengunjung as $row) {
        $data[] = [
            $row['nis'] ?? '',
            $row['nama'] ?? '',
            $row['rayon'] ?? '',
            $row['kamar'] ?? ''
        ];
    }
    
    exportToExcel($headers, $data, 'Data_Pengunjung_' . date('Y-m-d_H-i-s'));
}

elseif ($type == 'anggota') {
    $anggota = new Anggota();
    $dataAnggota = $anggota->tampilDataAnggota();
    
    $headers = ['ID Anggota', 'Nama', 'Kamar', 'Alamat'];
    $data = [];
    
    foreach ($dataAnggota as $row) {
        $data[] = [
            $row['id_anggota'] ?? '',
            $row['nama'] ?? '',
            $row['kamar'] ?? '',
            $row['alamat'] ?? ''
        ];
    }
    
    exportToExcel($headers, $data, 'Data_Anggota_' . date('Y-m-d_H-i-s'));
}

elseif ($type == 'peminjaman') {
    $peminjaman = new Peminjaman();
    $dataPeminjaman = $peminjaman->tampilDataPeminjaman();
    
    $headers = ['ID Peminjaman', 'Nama Anggota', 'Judul Buku', 'Tanggal Peminjaman', 'Tanggal Pengembalian', 'Status'];
    $data = [];
    
    foreach ($dataPeminjaman as $row) {
        $data[] = [
            $row['id_peminjaman'] ?? '',
            $row['nama_anggota'] ?? '',
            $row['judul'] ?? '',
            $row['tanggal_peminjaman'] ?? '',
            $row['tanggal_pengembalian'] ?? '',
            $row['status'] ?? ''
        ];
    }
    
    exportToExcel($headers, $data, 'Data_Peminjaman_' . date('Y-m-d_H-i-s'));
}

elseif ($type == 'pengembalian') {
    $pengembalian = new Pengembalian();
    $dataPengembalian = $pengembalian->tampilDataPengembalian();
    
    $headers = ['ID Peminjaman', 'Nama Anggota', 'Judul Buku', 'Tanggal Peminjaman', 'Tanggal Pengembalian', 'Status'];
    $data = [];
    
    foreach ($dataPengembalian as $row) {
        $data[] = [
            $row['id_peminjaman'] ?? '',
            $row['nama_anggota'] ?? '',
            $row['judul'] ?? '',
            $row['tanggal_peminjaman'] ?? '',
            $row['tanggal_pengembalian'] ?? '',
            $row['status'] ?? ''
        ];
    }
    
    exportToExcel($headers, $data, 'Data_Pengembalian_' . date('Y-m-d_H-i-s'));
}

else {
    header('Location: laporan.php');
    exit;
}
?>
