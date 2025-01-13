<?php

require_once 'database.php';

class listQuery extends database {

    public function isiForm($id_divisi, $id_divisi_kepada, $no_dokumen, $inv_dokumen, $nama_dokumen, $pengirim, $dari_div, $kepada_div, $penerima, $nm_file, $filecontent, $jenis_dokumen, $status) {
        $queryNama = mysqli_query($this->conn, "SELECT * FROM tb_divisi WHERE id_divisi=$id_divisi");
        $hasilQueryNama = mysqli_fetch_array($queryNama);
        $dari_div = $hasilQueryNama[1];
        echo $dari_div;

        $queryNama2 = mysqli_query($this->conn, "SELECT * FROM tb_divisi WHERE id_divisi=$id_divisi_kepada");
        $hasilQueryNama2 = mysqli_fetch_array($queryNama2);
        $kepada_div = $hasilQueryNama2[1];
        echo $kepada_div;

        $queryNoDoc = mysqli_query($this->conn, "SELECT MAX(no_dokumen) AS no_dokumen FROM tb_dokumen WHERE id_divisi_kepada=$id_divisi_kepada AND YEAR(tgl_masuk) = YEAR(NOW())");
        $hasilQuery = mysqli_fetch_array($queryNoDoc);

        if ($hasilQuery['no_dokumen'] == '') {
            $bulan = date("m/Y");
            $inv_dokumen = '1/'.$kepada_div.'/'.$bulan;
            $no_dokumen = 1;
        } else {
            $bulan = date("m/Y");
            $no_dokumen = (int)$hasilQuery['no_dokumen'] + 1;
            $inv_dokumen = $no_dokumen.'/'.$kepada_div.'/'.$bulan;
        }

        $query = $this->conn->prepare("INSERT INTO tb_dokumen (id_divisi, id_divisi_kepada, no_dokumen, inv_dokumen, nama_dokumen, pengirim, dari_div, kepada_div, penerima, nm_file, filecontent, jenis_dokumen, status, tgl_masuk) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())");
        if ($query === false) {
            die ("error prep state : ".$this->conn->error);
        }
        $null = NULL;
        $query->bind_param("iissssssssbss", $id_divisi, $id_divisi_kepada, $no_dokumen, $inv_dokumen, $nama_dokumen, $pengirim, $dari_div, $kepada_div, $penerima, $nm_file, $null, $jenis_dokumen, $status);
        $query->send_long_data(10, $filecontent);
        if ($query->execute()) {
            return true;
        } else {
            die("error exc state : ".$query->error);
        }
    }

    // fungsi untuk menampilkan hasil dokumen keluar yang telah di buat setelah mengisi form dokumen
    public function document($id_user){
        // $viewDoc = mysqli_query($this->conn, "SELECT * FROM tb_dokumen");
        $viewDoc = mysqli_query($this->conn, "SELECT * FROM tb_dokumen A, tb_user B, tb_divisi C WHERE A.id_divisi=C.id_divisi AND B.id_user='$id_user' AND B.id_divisi = C.id_divisi");
        // $viewDoc = mysqli_query($this->conn, "SELECT * FROM tb_user A, tb_dokumen B WHERE A.id_user=$id_user AND B.penerima='Amad' OR (B.kepada_div='Akuntansi' AND B.penerima='all')");
        mysqli_fetch_assoc($viewDoc);
        if ($viewDoc->num_rows > 0){
            return $viewDoc;
        } else {
            return false;
        }
    }

    
    // fungsi untuk menampilkan data yang berada di database, dengan ketentuan tertentu.
    // yaitu jika user yang login adalah divisi IT maka data dokumen yang diambil dari database hanya dokumen yang dikirim untuk divisi IT saja.
    public function documentIn($id_user){

        $docIn = mysqli_query($this->conn,"SELECT * FROM tb_dokumen A, tb_user B WHERE B.id_user=$id_user AND A.id_divisi=B.id_divisi AND status='pendingDari' OR A.penerima='all'=B.id_user ORDER BY no_dokumen DESC");

        
        mysqli_fetch_assoc($docIn);
        if ($docIn->num_rows > 0){
            return $docIn;
        } else {
            return false;
        }
    }

    public function documentIn2($id_user){

        $docIn = mysqli_query($this->conn,"SELECT * FROM tb_dokumen A, tb_user B WHERE B.id_user=$id_user AND A.id_divisi_kepada=B.id_divisi AND status='pendingKepada' OR A.penerima='all'=B.id_user ORDER BY no_dokumen DESC");
        
        mysqli_fetch_assoc($docIn);
        if ($docIn->num_rows > 0){
            return $docIn;
        } else {
            return false;
        }
    }

    public function documentIn3($id_user){

        $docIn = mysqli_query($this->conn,"SELECT * FROM tb_dokumen A, tb_user B WHERE B.id_user=$id_user AND A.id_divisi_kepada=B.id_divisi AND status='Accept' OR A.penerima='all'=B.id_user ORDER BY no_dokumen DESC");
        
        mysqli_fetch_assoc($docIn);
        if ($docIn->num_rows > 0){
            return $docIn;
        } else {
            return false;
        }
    }

    public function riwayatMasuk($id_user){
        $hisIn = mysqli_query($this->conn,"SELECT * FROM tb_dokumen A, tb_user B WHERE B.id_user=$id_user AND A.id_divisi_kepada=B.id_divisi AND status='Finish' OR A.penerima='all'=B.id_user ORDER BY no_dokumen DESC");

        mysqli_fetch_assoc($hisIn);
        if ($hisIn->num_rows > 0){
            return $hisIn;
        } else { 
            return false;
        }
    }

    public function riwayatKeluar($id_user){
        $hisIn = mysqli_query($this->conn,"SELECT * FROM tb_dokumen A, tb_user B WHERE B.id_user=$id_user AND A.id_divisi=B.id_divisi OR A.penerima='all'=B.id_user ORDER BY no_dokumen DESC");

        mysqli_fetch_assoc($hisIn);
        if ($hisIn->num_rows > 0){
            return $hisIn;
        } else { 
            return false;
        }
    }

    public function drDiv($id_user){
        $query = mysqli_query($this->conn, "SELECT deskripsi FROM tb_divisi A, tb_user B WHERE A.id_divisi = B.id_divisi AND B.id_user=$id_user");
        return mysqli_fetch_assoc($query);
    }

    // fungsi untuk menampilkan nama divisi untuk button select (dari divisi & kepada divisi)
    public function divisi(){
        $queryDiv = mysqli_query($this->conn, "SELECT id_divisi,deskripsi FROM tb_divisi");
        mysqli_fetch_assoc($queryDiv);
        if ($queryDiv->num_rows > 0){
            return $queryDiv;
        } else {
            return false;
        }
    }

    public function lvlPenerima(){
        // $queryLVL = mysqli_query($this->conn,"SELECT * FROM tb_user WHERE lvl='approval'");
        $queryLVL = mysqli_query($this->conn,"SELECT * FROM tb_user");
        mysqli_fetch_assoc($queryLVL);
        if ($queryLVL->num_rows > 0){
            return $queryLVL;
        } else {
            return false;
        }
    }

    function updateStatus(){
        $table = $_POST['table'];
        $field = $_POST['field'];
        $id = $_POST['id'];
        // $id_user = $_SESSION["id_user"];
        // $id_dokumen = $_POST['id_dokumen'];
        $status = $_POST['status'];
        // $status = $_POST['status'];
        $result = mysqli_query($this->conn, "UPDATE $table SET status='$status', tgl_diterima=(NOW()) WHERE $field='$id'");

        return $result;
    }

    function rejectStatus(){
        $table = $_POST['table'];
        $field = $_POST['field'];
        $id = $_POST['id'];
        $status = $_POST['status'];

        $result = mysqli_query($this->conn, "UPDATE $table SET status='$status' WHERE $field='$id'");
        return $result;


    }

    function finishDoc(){
        $table = $_POST['table'];
        $field = $_POST['field'];
        $id = $_POST['id'];

        $status = $_POST['status'];

        $result = mysqli_query($this->conn, "UPDATE $table SET status='$status',tgl_selesai=(NOW()) WHERE $field='$id'");

        return $result;
    }

    public function listFile(){
        $query = "SELECT id_dokumen, nm_file FROM tb_dokumen";
        $hasil = $this->conn->query($query);
        return $hasil->fetch_all(MYSQLI_ASSOC);
    }

    public function getFiles($id_dokumen){
        $query = "SELECT nm_file, filecontent FROM tb_dokumen WHERE id_dokumen = ?";
        $qfile = $this->conn->prepare($query);
        $qfile->bind_param("i", $id_dokumen);
        $qfile->execute();
        $hasil = $qfile->get_result();
        return $hasil->fetch_assoc();
    }


    public function hisKeluar($id_user){
        $query = mysqli_query($this->conn,"SELECT COUNT(no_dokumen) AS Total FROM tb_dokumen A, tb_user B WHERE B.id_user = $id_user AND A.id_divisi=B.id_divisi  AND STATUS = 'finish'");
        return mysqli_fetch_assoc($query);
    }

    public function hisMasuk($id_user){
        $query = mysqli_query($this->conn,"SELECT COUNT(no_dokumen) AS Total FROM tb_dokumen A, tb_user B WHERE B.id_user = $id_user AND B.id_divisi = A.id_divisi_kepada  AND STATUS = 'finish'");
        return mysqli_fetch_assoc($query);
    }

    public function reject($id_user){
        $query = mysqli_query($this->conn,"SELECT COUNT(no_dokumen) AS Total FROM tb_dokumen A, tb_user B WHERE B.id_user = $id_user AND A.id_divisi=B.id_divisi  AND STATUS = 'reject'");
        return mysqli_fetch_assoc($query);

    }

    public function dashPenFrom($id_user){
        $query = mysqli_query($this->conn,"SELECT COUNT(no_dokumen) AS Total FROM tb_dokumen A, tb_user B WHERE B.id_user = $id_user AND A.id_divisi=B.id_divisi  AND STATUS = 'pendingDari'");
        return mysqli_fetch_assoc($query);
    }

    public function dashPenTo($id_user){
        $query = mysqli_query($this->conn,"SELECT COUNT(no_dokumen) AS Total FROM tb_dokumen A, tb_user B WHERE B.id_user = $id_user AND A.id_divisi_kepada=B.id_divisi  AND STATUS = 'pendingKepada'");
        return mysqli_fetch_assoc($query);
    }

    public function monDoc($id_user){
        $query = mysqli_query($this->conn,"SELECT COUNT(no_dokumen) AS Total FROM tb_dokumen A, tb_user B WHERE B.id_user = 2 AND A.id_divisi=B.id_divisi  AND MONTH(tgl_masuk) = MONTH(NOW()) AND YEAR(tgl_masuk) = YEAR(NOW())");
        return mysqli_fetch_assoc($query);
    }

    public function dashIn($id_user){
        $query = mysqli_query($this->conn,"SELECT * FROM tb_dokumen A, tb_user B WHERE B.id_user=$id_user AND A.id_divisi_kepada=B.id_divisi AND status='pendingKepada' OR A.penerima='all'=B.id_user ORDER BY no_dokumen DESC LIMIT 2");
        
        mysqli_fetch_assoc($query);
        if ($query->num_rows > 0){
            return $query;
        } else {
            return false;
        }
    }

    public function dashOut($id_user){
        $query = mysqli_query($this->conn,"SELECT * FROM tb_dokumen A, tb_user B WHERE B.id_user=$id_user AND A.id_divisi=B.id_divisi AND status='pendingDari' OR A.penerima='all'=B.id_user ORDER BY no_dokumen DESC LIMIT 2");
        
        mysqli_fetch_assoc($query);
        if ($query->num_rows > 0){
            return $query;
        } else {
            return false;
        }
    }
}
?>
