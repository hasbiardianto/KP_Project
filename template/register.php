<?php

require_once 'database.php';

class register extends database {
    public function registrasi($id_divisi, $nama_user, $pass, $lvl) {
        $duplicate = mysqli_query($this->conn, "SELECT * FROM tb_user where nama_user = '$nama_user'");
        if (mysqli_num_rows($duplicate) > 0) {
            return 10;
        } else {
            if ($pass) {
                $hashed_password = password_hash($pass, PASSWORD_DEFAULT);          
                $queryPass = mysqli_query($this->conn, "INSERT INTO tb_user (id_divisi, nama_user, pass, lvl) VALUES ('$id_divisi', '$nama_user', '$hashed_password', '$lvl')");
                return 1;
            }
        }
    }
}

?>
