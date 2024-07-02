<?php
require '.././koneksi.php';
$pdf = new listQuery();
if (isset($_GET['id_dokumen']) && is_numeric($_GET['id_dokumen'])){
    $id_dokumen = intval($_GET['id_dokumen']);

    $file = $pdf->getFiles($id_dokumen);
    if ($file){
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>View PDF</title>
        </head>
        <body>
            <embed src="data:application/pdf;base64,' . base64_encode($file['filecontent']) . '" type="application/pdf" width="100%" height="940px" />
            <!-- atau menggunakan <iframe> -->
            <!-- <iframe src="data:application/pdf;base64,' . base64_encode($file['filecontent']) . '" width="100%" height="600px"></iframe> -->
        </body>
        </html>';
    } else {
        echo "File tidak ditemukan!";
    }
} else {
    echo "ID dokumen tidak valid!";
}
?>