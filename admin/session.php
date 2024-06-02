<?php
session_start();

// Cek jika pengguna belum login, maka redirect ke halaman login

if ($_SESSION['role'] != 1) {
    header("Location:  ../");
    exit;
}
