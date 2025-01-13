<?php

require_once 'database.php';

class masuk extends database {
    public $id_user;
    public $nama_user;
    public $lvl;

    public function userMasuk($nama_user, $pass) {
        $queryLog = mysqli_query($this->conn, "SELECT * FROM tb_user where nama_user = '$nama_user'");
        $row = mysqli_fetch_assoc($queryLog);
        $passNow = $row['pass'];

        if (mysqli_num_rows($queryLog) > 0) {
            if ($pass == $passNow || password_verify($pass, $passNow)) {
                $this->id_user = $row["id_user"];
                $this->nama_user = $row["nama_user"];
                $this->lvl = $row["lvl"];
                return 1;
            } else {
                return 10;
            }
        } else {
            return 100;
        }
    }

    public function userID() {
        return $this->id_user;
    }

    public function nmUser() {
        return $this->nama_user;
    }

    public function lvlUsr() {
        return $this->lvl;
    }

    public function userSelected($id_user) {
        $hasilSelect = mysqli_query($this->conn, "SELECT A.nama_user,A.lvl,B.deskripsi FROM tb_user A, tb_divisi B WHERE A.id_user='$id_user' AND A.id_divisi=B.id_divisi");
        return mysqli_fetch_assoc($hasilSelect);
    }
}

?>
