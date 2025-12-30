<?php
require_once('database.php');
class Peminjaman extends Database
{
    public function simpan($id_peminjaman, $id_anggota, $id_pustakawan, $kode_buku, $tanggal_peminjaman, $status = 'dipinjam')
    {
        // Hitung tanggal pengembalian (4 hari setelah tanggal peminjaman)
        $date = new DateTime($tanggal_peminjaman);
        $date->modify('+4 days');
        $tanggal_pengembalian = $date->format('Y-m-d');
        
        $stmt = $this->getKoneksi()->prepare("INSERT INTO peminjaman (id_peminjaman, id_anggota, id_pustakawan, kode_buku, tanggal_peminjaman, tanggal_pengembalian, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$id_peminjaman, $id_anggota, $id_pustakawan, $kode_buku, $tanggal_peminjaman, $tanggal_pengembalian, $status]);
        return $result ? true : false;
    }

    public function tampilDataPeminjaman()
    { //function read
        $query = "SELECT 
                    p.id_peminjaman,
                    p.id_anggota,
                    p.id_pustakawan,
                    p.kode_buku,
                    a.nama as nama_anggota,
                    a.kamar,
                    pu.nama as nama_pustakawan,
                    b.judul,
                    p.tanggal_peminjaman,
                    p.tanggal_pengembalian,
                    p.status
                  FROM peminjaman p
                  JOIN anggota a ON p.id_anggota = a.id_anggota
                  JOIN pustakawan pu ON p.id_pustakawan = pu.id_pustakawan
                  JOIN buku b ON p.kode_buku = b.kode_buku
                  ORDER BY p.id_peminjaman DESC";
        $result = $this->getKoneksi()->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function hapus($id_peminjaman)
    { //function delete
        $stmt = $this->getKoneksi()->prepare("DELETE FROM peminjaman WHERE id_peminjaman = ?");
        $result = $stmt->execute([$id_peminjaman]);
        return $result ? true : false;
    }

    public function TampilById($id_peminjaman)
    {
        $stmt = $this->getKoneksi()->prepare("SELECT 
                                                p.id_peminjaman,
                                                p.id_anggota,
                                                p.id_pustakawan,
                                                p.kode_buku,
                                                a.nama as nama_anggota,
                                                a.kamar,
                                                pu.nama as nama_pustakawan,
                                                b.judul,
                                                p.tanggal_peminjaman,
                                                p.tanggal_pengembalian,
                                                p.status
                                              FROM peminjaman p
                                              JOIN anggota a ON p.id_anggota = a.id_anggota
                                              JOIN pustakawan pu ON p.id_pustakawan = pu.id_pustakawan
                                              JOIN buku b ON p.kode_buku = b.kode_buku
                                              WHERE p.id_peminjaman = ?");
        $stmt->bind_param("s", $id_peminjaman);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function ubah($id_peminjaman, $tanggal_pengembalian, $status)
    {
        $stmt = $this->getKoneksi()->prepare("UPDATE peminjaman SET tanggal_pengembalian = ?, status = ? WHERE id_peminjaman = ?");
        $result = $stmt->execute([$tanggal_pengembalian, $status, $id_peminjaman]);
        return $result ? true : false;
    }

    public function cariByKodeBuku($kode_buku)
    {
        $query = "SELECT kode_buku, judul FROM buku WHERE kode_buku = '$kode_buku'";
        $result = $this->getKoneksi()->query($query);
        return $result->fetch_assoc();
    }

    public function cariByIdAnggota($id_anggota)
    {
        $query = "SELECT id_anggota, nama FROM anggota WHERE id_anggota = '$id_anggota'";
        $result = $this->getKoneksi()->query($query);
        return $result->fetch_assoc();
    }
}
