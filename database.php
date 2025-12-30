<?php
class Database {
    private $koneksi;
    public function __construct() {
        $this->koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");
    }
    public function getKoneksi() {
        return $this->koneksi;
    }
    public function __destruct() {
        $this->koneksi->close();
    }
}
?>