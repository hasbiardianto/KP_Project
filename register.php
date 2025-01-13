<?php

require 'database.php';
require 'generate_token.php';

class Register extends Database {
    public function registrasi($id_divisi, $nama_user, $pass, $lvl) {
        $duplicate = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE nama_user = '$nama_user'");
        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // username telah digunakan
        } else {
            $query = "INSERT INTO tb_user (id_divisi, nama_user, pass, lvl) VALUES ('$id_divisi', '$nama_user', '$pass', '$lvl')";
            mysqli_query($this->conn, $query);
            return generateJWT($id_divisi);
        }
    }
}
?>