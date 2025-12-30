<?php
require_once('database.php');

class Pustakawan extends Database
{
    public function cariByIdPustakawan($id_pustakawan)
    {
        $stmt = $this->getKoneksi()->prepare("SELECT * FROM pustakawan WHERE id_pustakawan = ?");
        $stmt->bind_param("s", $id_pustakawan);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function tampilDataPustakawan()
    {
        $query = "SELECT * FROM pustakawan";
        $result = $this->getKoneksi()->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function updateAvatar($id_pustakawan, $avatarPath)
    {
        $stmt = $this->getKoneksi()->prepare("UPDATE pustakawan SET avatar = ? WHERE id_pustakawan = ?");
        $stmt->bind_param("ss", $avatarPath, $id_pustakawan);
        return $stmt->execute();
    }
}
?>
