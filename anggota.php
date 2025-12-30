<?php
require_once('database.php');
class Anggota extends Database
{
    public function simpan($id_anggota, $nama, $kamar, $alamat)
    {
        $query = "INSERT INTO anggota VALUES ('$id_anggota', '$nama', '$kamar', '$alamat')";
        $result = $this->getKoneksi()->query($query);
        return $result ? true : false;
    }
    public function tampilDataAnggota()
    { //function read
        $query = "SELECT * FROM anggota";
        $result = $this->getKoneksi()->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function hapus($id_anggota)
    { //function delete
        $query = "DELETE FROM anggota where id_anggota=$id_anggota";
        $result = $this->getKoneksi()->query($query);
        return $result ? true : false;
    }
    public function TampilById($id_anggota)
    {
        $query = "SELECT *FROM anggota where id_anggota=$id_anggota";
        $result = $this->getKoneksi()->query($query);
        return $result->fetch_assoc();
    }
    public function ubah($id_anggota, $nama, $kamar, $alamat)
    {
        $query = "UPDATE anggota SET nama='$nama', kamar='$kamar', alamat='$alamat' WHERE id_anggota=$id_anggota";
        $result = $this->getKoneksi()->query($query);
        return $result ? true : false;
    }
}
