<?php
session_start();

$uid = $_SESSION['uid'];

// Cek jika pengguna belum login, maka redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}


include('../api/conn.php');

// Mendapatkan bulan sekarang dan tahun sekarang
$bulanIni = date('m');
$namabulanIni = date('F');
$tahunIni = date('Y');

// Mendapatkan bulan lalu dan tahun lalu
$bulanLalu = date('m', strtotime('-1 month'));
$namabulanLalu = date('F', strtotime('-1 month'));
$tahunLalu = date('Y', strtotime('-1 year'));

$hariBulanIni = cal_days_in_month(CAL_GREGORIAN, $bulanIni, $tahunIni);
$hariBulanLalu = cal_days_in_month(CAL_GREGORIAN, $bulanLalu, $tahunIni);

$liburBulanIni = 0;
// Iterasi melalui setiap tanggal dalam bulan tersebut
for ($tanggal = 1; $tanggal <= $hariBulanIni; $tanggal++) {
    // Mendapatkan timestamp untuk tanggal yang sedang diperiksa
    $timestamp = mktime(0, 0, 0, $bulanIni, $tanggal, $tahunIni);

    // Mendapatkan nomor hari (0: Minggu, 1: Senin, ..., 6: Sabtu)
    $nomorHari = date('w', $timestamp);

    // Jika nomor hari adalah 0 (Minggu) atau 6 (Sabtu), tambahkan ke counter yang sesuai
    if ($nomorHari == 0 || $nomorHari == 6) {
        $liburBulanIni++;
    }
}
$liburBulanLalu = 0;
// Iterasi melalui setiap tanggal dalam bulan tersebut
for ($tanggal = 1; $tanggal <= $hariBulanLalu; $tanggal++) {
    // Mendapatkan timestamp untuk tanggal yang sedang diperiksa
    $timestamp = mktime(0, 0, 0, $bulanLalu, $tanggal, $tahunIni);

    // Mendapatkan nomor hari (0: Minggu, 1: Senin, ..., 6: Sabtu)
    $nomorHari = date('w', $timestamp);

    // Jika nomor hari adalah 0 (Minggu) atau 6 (Sabtu), tambahkan ke counter yang sesuai
    if ($nomorHari == 0 || $nomorHari == 6) {
        $liburBulanLalu++;
    }
}

$hariKerjaBulanIni = $hariBulanIni - $liburBulanIni;
$hariKerjaBulanLalu = $hariBulanLalu - $liburBulanLalu;

$absenBulanIni = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS totalAbsensi FROM absensi WHERE bulan = '$namabulanIni' AND uid = '$uid'"));
$absenBulanLalu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS totalAbsensi FROM absensi WHERE bulan = '$namabulanLalu' AND uid = '$uid'"));



?>
<!DOCTYPE html>
<html lang="en">

<?php include("templates/head.php") ?>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="logo">
                <a href="#" class="simple-text logo-normal text-center">
                    Absensi Ver.1
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="active ">
                        <a href="../karyawan">
                            <i class="nc-icon nc-bank"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="../karyawan/profile.php">
                            <i class="nc-icon nc-single-02"></i>
                            <p>User Profile</p>
                        </a>
                    </li>
                    <li>
                        <a href="./notifications.html">
                            <i class="nc-icon nc-bell-55"></i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    <li class="active-pro">
                        <a href="../logout.php" class="text-danger">
                            <i class="nc-icon nc-user-run text-danger"></i>
                            <p>Log Out</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="javascript:;">Dashboard</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav mr-2">

                            <li>

                                <p>
                                    Hallo , <?= $_SESSION['username'] ?>

                                </p>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item btn-rotate dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="../assets/img/default-avatar.png" alt="" width="30px" style="border-radius: 100%;border:1px solid black;">
                                    <p>
                                        <span class="d-lg-none d-md-block">Some Actions</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="logout.php">Log Out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <!-- card 4 -->
                <?php include('templates/card.php') ?>
                <!-- tabel Absensi -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title">Absensi</h4>
                                <div class="">
                                    <select id="selectTanggal" class="form-control">
                                        <option value="">Pilih Bulan</option>
                                        <!-- Opsi tanggal akan dimuat menggunakan JavaScript -->
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                            <th>
                                                Tanggal
                                            </th>
                                            <th>
                                                Masuk
                                            </th>
                                            <th>
                                                Keluar
                                            </th>
                                            <th class="text-center" colspan="2">
                                                Keterangan
                                            </th>
                                        </thead>
                                        <tbody id="dataAbsensi">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                var dates = JSON.parse(this.responseText); // Menguraikan respons JSON
                                var select = document.getElementById("selectTanggal");

                                // Mengisi elemen select dengan opsi dari data JSON
                                dates.forEach(function(date) {
                                    var option = document.createElement("option");
                                    option.value = date;
                                    option.text = date;
                                    select.appendChild(option);
                                });
                            }
                        };
                        xhr.open("GET", "../api/bulan.php", true);
                        xhr.send();

                        document.getElementById("selectTanggal").addEventListener("change", function() {
                            var selectedDate = this.value;
                            if (selectedDate) {
                                fetchData(selectedDate);
                            } else {
                                document.getElementById("dataAbsensi").innerHTML = "";
                            }
                        });

                        function fetchData(selectedDate) {
                            var xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("dataAbsensi").innerHTML = this.responseText;
                                }
                            };
                            xhr.open("GET", "../api/read_absensi_bulan.php?tanggal=" + selectedDate, true);
                            xhr.send();
                        }
                    </script>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header ">
                                <h5 class="card-title">Kinerja</h5>
                                <p class="card-category">1 Tahun Terakhir</p>
                            </div>
                            <div class="card-body ">
                                <canvas id=kinerja height="40px"></canvas>
                            </div>
                            <div class="card-footer ">
                                <hr>
                                <div class="stats">
                                    <i class="fa fa-history"></i> Updated 3 minutes ago
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php include("templates/footer.php") ?>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var chartColor = "#FFFFFF";
            var ctx = document.getElementById('kinerja').getContext("2d");

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Des"],
                    datasets: [{
                        borderColor: "#6bd098",
                        backgroundColor: "rgba(107, 208, 152, 0)",
                        pointRadius: 5,
                        pointHoverRadius: 5,
                        borderWidth: 3,
                        data: [80, 88, 90, 85, 70, 90, 80, 95, 90, 80, 80, 75]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                fontColor: "#9f9f9f",
                                beginAtZero: false,
                                maxTicksLimit: 10
                            },
                            gridLines: {
                                drawBorder: false,
                                zeroLineColor: "#ccc",
                                color: 'rgba(255,255,255,0.05)'
                            }
                        }],
                        xAxes: [{
                            barPercentage: 1.6,
                            gridLines: {
                                drawBorder: false,
                                color: 'rgba(255,255,255,0.1)',
                                zeroLineColor: "transparent",
                                display: false
                            },
                            ticks: {
                                padding: 20,
                                fontColor: "#9f9f9f"
                            }
                        }]
                    }
                }
            });
        });
    </script>

    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <!-- <script src="../assets/js/plugins/chartjs.min.js"></script> -->
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="../assets/demo/demo.js"></script>
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
            demo.initChartsPages();
        });
    </script>
</body>

</html>