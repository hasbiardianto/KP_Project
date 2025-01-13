<?php

require_once 'database.php';
require_once 'generate_token.php';

class Login extends Database {
    public $id_user;
    public $nama_user;
    public $lvl;

    public function userMasuk($nama_user, $pass) {
        $queryLog = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE nama_user = '$nama_user'");
        $row = mysqli_fetch_assoc($queryLog);
        $passNow = $row['pass'];

        if (mysqli_num_rows($queryLog) > 0) {
            if ($pass == $passNow || password_verify($pass, $passNow)) {
                $this->id_user = $row["id_user"];
                $this->nama_user = $row["nama_user"];
                $this->lvl = $row["lvl"];
                $id_divisi = $row["id_divisi"];

                // Generate JWT token
                $token = generateJWT($id_divisi);

                // Store token in session
                session_start();
                $_SESSION['token'] = $token;

                return 1;
            } else {
                return 10; // Password salah
            }
        } else {
            return 100; // User tidak ditemukan
        }
    }
}
?>