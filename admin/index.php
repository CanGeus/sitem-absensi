<?php

include("session.php");

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

<!DOCTYPE html>
<html lang="en">

<?php include("../templates/head.php") ?>

<style>
    a:hover {
        text-decoration: none;
    }
</style>

<script>
    window.onload = function() {
        checkMode();
    };

    function checkMode() {
        var xhr = new XMLHttpRequest();
        var url = "../api/read_mode.php";

        xhr.open("GET", url, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                var mode = response[0].kondisi;
                document.getElementById("mode").innerText = mode;
                var switchCheckbox = document.getElementById("switchCheckbox");
                switchCheckbox.checked = (mode === "add");
            }
        };

        xhr.send();
    }

    function changeMode(element) {
        var mode = element.checked ? "add" : "read";
        document.getElementById("mode").innerText = mode;
        sendMode(mode);
    }

    function sendMode(mode) {
        var xhr = new XMLHttpRequest();
        var url = "../api/update_mode.php";
        var params = "mode=" + mode;

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Response dari server
                console.log(xhr.responseText);
            }
        };

        xhr.send(params);
    }
</script>



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
                    <li class="active">
                        <a href="../admin">
                            <i class="nc-icon nc-bank"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/export.php">
                            <i class="nc-icon nc-tile-56"></i>
                            <p>Export Data</p>
                        </a>
                    </li>
                    <li>
                        <a href="./user.html">
                            <i class="nc-icon nc-single-02"></i>
                            <p>User Profile</p>
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
                        <ul class="navbar-nav">
                            <li class="nav-item btn-rotate dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nc-icon nc-settings-gear-65"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Some Actions</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="../logout.php">Log Out</a>
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
                                <h4 class="card-title"> Simple Table</h4>
                                <div class="">
                                    <select id="selectTanggal" class="form-control">
                                        <option value="">Pilih Tanggal</option>
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
                                            <th class="text-center">
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
                        xhr.open("GET", "../api/tanggal.php", true);
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
                            xhr.open("GET", "../api/read_absensi_tanggal.php?tanggal=" + selectedDate, true);
                            xhr.send();
                        }
                    </script>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header ">
                                <h5 class="card-title">Users Behavior</h5>
                                <p class="card-category">24 Hours performance</p>
                            </div>
                            <div class="card-body ">
                                <canvas id=chartHours width="400" height="100"></canvas>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="card ">
                            <div class="card-header ">
                                <h5 class="card-title">Email Statistics</h5>
                                <p class="card-category">Last Campaign Performance</p>
                            </div>
                            <div class="card-body ">
                                <canvas id="chartEmail"></canvas>
                            </div>
                            <div class="card-footer ">
                                <div class="legend">
                                    <i class="fa fa-circle text-primary"></i> Opened
                                    <i class="fa fa-circle text-warning"></i> Read
                                    <i class="fa fa-circle text-danger"></i> Deleted
                                    <i class="fa fa-circle text-gray"></i> Unopened
                                </div>
                                <hr>
                                <div class="stats">
                                    <i class="fa fa-calendar"></i> Number of emails sent
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="card-title">NASDAQ: AAPL</h5>
                                <p class="card-category">Line Chart with Points</p>
                            </div>
                            <div class="card-body">
                                <canvas id="speedChart" width="400" height="100"></canvas>
                            </div>
                            <div class="card-footer">
                                <div class="chart-legend">
                                    <i class="fa fa-circle text-info"></i> Tesla Model S
                                    <i class="fa fa-circle text-warning"></i> BMW 5 Series
                                </div>
                                <hr />
                                <div class="card-stats">
                                    <i class="fa fa-check"></i> Data information certified
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card text-center">
                        <div class="card">
                            <div class="card-body">
                                <style>
                                    /* CSS untuk tampilan tombol switch */
                                    .switch {
                                        position: relative;
                                        display: inline-block;
                                        width: 60px;
                                        height: 34px;
                                    }

                                    .switch input {
                                        opacity: 0;
                                        width: 0;
                                        height: 0;
                                    }

                                    .slider {
                                        position: absolute;
                                        cursor: pointer;
                                        top: 0;
                                        left: 0;
                                        right: 0;
                                        bottom: 0;
                                        background-color: #ccc;
                                        -webkit-transition: .4s;
                                        transition: .4s;
                                    }

                                    .slider:before {
                                        position: absolute;
                                        content: "";
                                        height: 26px;
                                        width: 26px;
                                        left: 4px;
                                        bottom: 4px;
                                        background-color: white;
                                        -webkit-transition: .4s;
                                        transition: .4s;
                                    }

                                    input:checked+.slider {
                                        background-color: #2196F3;
                                    }

                                    input:focus+.slider {
                                        box-shadow: 0 0 1px #2196F3;
                                    }

                                    input:checked+.slider:before {
                                        -webkit-transform: translateX(26px);
                                        -ms-transform: translateX(26px);
                                        transform: translateX(26px);
                                    }

                                    /* Rounded sliders */
                                    .slider.round {
                                        border-radius: 34px;
                                    }

                                    .slider.round:before {
                                        border-radius: 50%;
                                    }
                                </style>
                                <h2>Mode: <span id="mode"></span></h2>
                                <label class="switch">
                                    <input id="switchCheckbox" type="checkbox" onchange="changeMode(this)">
                                    <span class="slider round"></span>
                                </label>

                                <script>
                                    function changeMode(element) {
                                        var mode = element.checked ? "add" : "read";
                                        document.getElementById("mode").innerText = mode;
                                        sendMode(mode);
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php include("../templates/footer.php") ?>
        </div>
    </div>



    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="assets/demo/demo.js"></script>
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
            demo.initChartsPages();
        });
    </script>
</body>

</html>