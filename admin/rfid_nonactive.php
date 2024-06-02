<?php

include("session.php");

include("../api/conn.php");

?>

<!DOCTYPE html>
<html lang="en">

<?php include("templates/head.php") ?>

<style>
    a:hover {
        text-decoration: none;
    }
</style>

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
                        <a class="navbar-brand" href="javascript:;">RDIF NONACTIVE</a>
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
                                <h4 class="card-title">Daftar RDIF Non Active</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                            <th>
                                                UID
                                            </th>
                                            <th class="text-center">
                                                Action
                                            </th>
                                            <!-- <th class="text-center">
                                                Action
                                            </th> -->
                                        </thead>
                                        <tbody>
                                            <?php
                                            $queryKaryawan = "SELECT * FROM karyawan WHERE nama IS NULL";
                                            $resultKaryawan = $conn->query($queryKaryawan);
                                            if ($resultKaryawan->num_rows > 0) {
                                                while ($rowKaryawan = $resultKaryawan->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td><?= $rowKaryawan['uid'] ?></td>
                                                        <td class="text-center">
                                                            <a href="../admin/update_user.php?uid=<?= $rowKaryawan['uid'] ?>">
                                                                <button type="button" class="btn btn-success">Activate</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo '<h5 class="text-center text-uppercase">Tidak Ada RFID yang Nonactive</h5>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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