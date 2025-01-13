<?php
// echo "dashboard";


$total = $ListQuery->hisKeluar($_SESSION["id_user"]);
$totalMasuk = $ListQuery->hisMasuk($_SESSION["id_user"]);
$rejected = $ListQuery->reject($_SESSION["id_user"]);
$penFrom = $ListQuery->dashPenFrom($_SESSION["id_user"]);
$penTo= $ListQuery->dashPenTo($_SESSION["id_user"]);
$monthly = $ListQuery->monDoc($_SESSION["id_user"]);
// $pdf = $ListQuery->listFile();
$inPrev = $ListQuery->dashIn($_SESSION["id_user"]);
$OutPrev = $ListQuery->dashOut($_SESSION["id_user"]);


?>
<!-- <h3 class="font-weight-normal">total surat keluar</h3>
<h5 class="font-weight-normal"><?php echo $total['Total'];?></h5><br>

<h3 class="font-weight-normal">total surat Masuk</h3>
<h5 class="font-weight-normal"><?php echo $totalMasuk['Total'];?></h5>

<h3 class="font-weight-normal">total surat reject</h3>
<h5 class="font-weight-normal"><?php echo $rejected['Total'];?></h5> -->

<!-- PREVIEW SURAT MASUK MULAI -->
<!-- <table class="table table-hover">
    <thead>
        <tr>
            <th>Inv.Dok</th>
            <th>nama dokumen</th>
            <th>jenis dokumen</th>
            <th>pengirim</th>                           
            <th>dari div</th>
            <th>Kepada div</th>
            <th>penerima</th>
            <th>file</th>
            <th>Status</th>
            <th>Masuk</th>
            <th>Acc</th>
            <th>Finish</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    if ($inPrev){
        foreach($inPrev as $prev) { ?>
                    <tr>
                        <td><?=$prev["inv_dokumen"];?></td>
                        <td><?=$prev["nama_dokumen"];?></td>
                        <td><?=$prev["jenis_dokumen"];?></td>
                        <td><?=$prev["pengirim"]; ?></td>
                        <td><?=$prev["dari_div"]; ?></td>
                        <td><?=$prev["kepada_div"]; ?></td>
                        <td><?=$prev["penerima"]; ?></td>
                        <td><?=$prev["nm_file"]; ?></td>
                        <td><?=$prev["status"]; ?></td>
                        <td><?=$prev["tgl_masuk"]; ?></td>
                        <td><?=$prev["tgl_diterima"]; ?></td>
                        <td><?=$prev["tgl_selesai"];?></td>          
                    </tr>

    <?php    }
    }
    ?>
    </tbody>
</table> -->

<!-- PREVIEW SURAT MASUK SELESAI -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="main-panel">
        <div class="content-wrapper" style="margin-left: 7em;">
            <div class="row">
                <!-- DASH SURAT KELUAR -->
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="font-weight-normal text-center">Total surat keluar</h5><br>
                            <h4 class="font-weight-normal text-center"><?php echo $total['Total'];?></h4>
                        </div>
                    </div>
                </div>

                <!-- DASH SURAT MASUK -->
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <!-- <div class="d-flex justify-content-between align-items-center mb-3"> -->
                                <h5 class="font-weight-normal text-center">Total surat Masuk</h5><br>
                                <h4 class="font-weight-normal text-center"><?php echo $totalMasuk['Total'];?></h4>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>

                <!-- DASH SURAT REJECT -->
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <!-- <div class="d-flex justify-content-between align-items-center mb-3"> -->
                                <h5 class="font-weight-normal text-center">Surat Ditolak</h5><br>
                                <h4 class="font-weight-normal text-center"><?php echo $rejected['Total'];?></h4>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>

                <!-- DASH PENDING APPROVAL -->
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <!-- <div class="d-flex justify-content-between align-items-center mb-3"> -->
                                <h5 class="font-weight-normal text-center">Pending Approval</h5><br>
                                <h4 class="font-weight-normal text-center"><?php echo $penFrom['Total'] + $penTo['Total'];?></h4>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>

                <!-- DASH TOTAL Surat Bulan Ini -->
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <!-- <div class="d-flex justify-content-between align-items-center mb-2"> -->
                                <h5 class="font-weight-normal text-center">Dokumen Bulan Ini</h5><br>
                                <h4 class="font-weight-normal text-center"><?php echo $monthly['Total'];?></h4>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="table-responsive pt-3">
                            <table class="table table-striped project-orders-table">
                                <thead>
                                    <tr>
                                        <th>Inv.Dok</th>
                                        <th>nama dokumen</th>
                                        <th>jenis dokumen</th>
                                        <th>pengirim</th>                           
                                        <th>dari div</th>
                                        <th>Kepada div</th>
                                        <th>penerima</th>
                                        <th>file</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if ($OutPrev){
                                        foreach($OutPrev as $prev){ ?>
                                                    <tr>
                                                        <td><?=$prev["inv_dokumen"];?></td>
                                                        <td><?=$prev["nama_dokumen"];?></td>
                                                        <td><?=$prev["jenis_dokumen"];?></td>
                                                        <td><?=$prev["pengirim"]; ?></td>
                                                        <td><?=$prev["dari_div"]; ?></td>
                                                        <td><?=$prev["kepada_div"]; ?></td>
                                                        <td><?=$prev["penerima"]; ?></td>
                                                        <td><?=$prev["nm_file"]; ?></td>
                                                        <td><?=$prev["status"]; ?></td>      
                                                    </tr>

                                    <?php    }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div><br>
                        <a href="index.php?page=dokumentasi" class="text-right" style="margin-right:10px; margin-bottom:10px;">
                            <button class="btn btn-outline-info">Go To</button>
                        </a>
                    </div>
                </div>
            </div><br><br>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="table-responsive pt-3">
                            <table class="table table-striped project-orders-table">
                                <thead>
                                    <tr>
                                        <th>Inv.Dok</th>
                                        <th>nama dokumen</th>
                                        <th>jenis dokumen</th>
                                        <th>pengirim</th>                           
                                        <th>dari div</th>
                                        <th>Kepada div</th>
                                        <th>penerima</th>
                                        <th>file</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if ($inPrev){
                                        foreach($inPrev as $prev){ ?>
                                                    <tr>
                                                        <td><?=$prev["inv_dokumen"];?></td>
                                                        <td><?=$prev["nama_dokumen"];?></td>
                                                        <td><?=$prev["jenis_dokumen"];?></td>
                                                        <td><?=$prev["pengirim"]; ?></td>
                                                        <td><?=$prev["dari_div"]; ?></td>
                                                        <td><?=$prev["kepada_div"]; ?></td>
                                                        <td><?=$prev["penerima"]; ?></td>
                                                        <td><?=$prev["nm_file"]; ?></td>
                                                        <td><?=$prev["status"]; ?></td>      
                                                    </tr>

                                    <?php    }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div><br>
                        <a href="index.php?page=dokumen_masuk" class="text-right" style="margin-right:10px; margin-bottom:10px;">
                            <button class="btn btn-outline-info">Go To</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>



