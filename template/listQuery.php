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

    // ...existing code for other methods...

}

?>
