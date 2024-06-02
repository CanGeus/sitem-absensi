<?php
include("../api/conn.php");

// Query untuk menghitung jumlah data
$resultTotalKaryawan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM karyawan WHERE nama IS NOT NULL");

// Ambil hasil
$row = mysqli_fetch_assoc($resultTotalKaryawan);
$totalKaryawan = $row['total'];

// Query untuk menghitung jumlah data
$resultTotalRFIDNonactive = mysqli_query($conn, "SELECT COUNT(*) AS total FROM karyawan WHERE nama IS NULL");

// Ambil hasil
$row = mysqli_fetch_assoc($resultTotalRFIDNonactive);
$totalRFIDNonactive = $row['total'];

// Query untuk menghitung jumlah data
$resultTotalRFID = mysqli_query($conn, "SELECT COUNT(*) AS total FROM karyawan");

// Ambil hasil
$row = mysqli_fetch_assoc($resultTotalRFID);
$totalRFID = $row['total'];
?>
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="../admin/rdif.php">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-credit-card text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">RFID</p>
                                <p class="card-title"><?= $totalRFID ?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i>
                        Update Now
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="../admin/karyawan.php">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-single-02 text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Karyawan</p>
                                <p class="card-title"><?= $totalKaryawan ?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-calendar-o"></i>
                        Last day
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="../admin/rfid_active.php">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-badge text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">RFID Active</p>
                                <p class="card-title"><?= $totalKaryawan ?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-clock-o"></i>
                        In the last hour
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="../admin/rfid_nonactive.php">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-badge text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">RDIF Nonactive</p>
                                <p class="card-title"><?= $totalRFIDNonactive ?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i>
                        Update now
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>