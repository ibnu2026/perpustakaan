<?php
require_once('database.php');
class Buku extends Database
{
    public function simpan($kode_buku, $judul, $penulis, $tahun_terbit, $penerbit, $id_kategori)
    {
        $query = "INSERT INTO buku (kode_buku, judul, penulis, tahun_terbit, penerbit, id_kategori) VALUES ('$kode_buku', '$judul', '$penulis', '$tahun_terbit', '$penerbit', '$id_kategori')";
        $result = $this->getKoneksi()->query($query);
        return $result ? true : false;
    }
    public function tampilDataBuku()
    { //function read
        $query = "SELECT buku.*, kategori.nama_kategori FROM buku JOIN kategori ON buku.id_kategori = kategori.id_kategori";
        $result = $this->getKoneksi()->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function hapus($kode_buku)
    { //function delete
        $query = "DELETE FROM buku WHERE kode_buku=$kode_buku";
        $result = $this->getKoneksi()->query($query);
        return $result ? true : false;
    }
    public function TampilByKode($kode_buku)
    {
        $query = "SELECT * FROM buku WHERE kode_buku=$kode_buku";
        $result = $this->getKoneksi()->query($query);
        return $result->fetch_assoc();
    }
    public function ubah($kode_buku, $judul, $penulis, $tahun_terbit, $penerbit, $id_kategori)
    {
        $query = "UPDATE buku SET judul='$judul', penulis='$penulis', tahun_terbit='$tahun_terbit', penerbit='$penerbit', id_kategori='$id_kategori' WHERE kode_buku=$kode_buku";
        $result = $this->getKoneksi()->query($query);
        return $result ? true : false;
    }
}
