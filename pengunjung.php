<?php
require_once('database.php');
class Pengunjung extends Database
{
    public function simpan($nis, $nama, $rayon, $kamar)
    {
        $stmt = $this->getKoneksi()->prepare("INSERT INTO pengunjung (nis, nama, rayon, kamar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nis, $nama, $rayon, $kamar);
        $result = $stmt->execute();
        return $result ? true : false;
    }
    public function tampilDataPengunjung()
    { //function read
        $query = "SELECT * FROM pengunjung";
        $result = $this->getKoneksi()->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function hapus($nis)
    { //function delete
        $stmt = $this->getKoneksi()->prepare("DELETE FROM pengunjung WHERE nis=?");
        $stmt->bind_param("s", $nis);
        $result = $stmt->execute();
        return $result ? true : false;
    }
    public function TampilBynis($nis)
    {
        $stmt = $this->getKoneksi()->prepare("SELECT * FROM pengunjung WHERE nis=?");
        $stmt->bind_param("s", $nis);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function ubah($nis, $nama, $rayon, $kamar)
    {
        $stmt = $this->getKoneksi()->prepare("UPDATE pengunjung SET nama=?, rayon=?, kamar=? WHERE nis=?");
        $stmt->bind_param("ssss", $nama, $rayon, $kamar, $nis);
        $result = $stmt->execute();
        return $result ? true : false;
    }
}
