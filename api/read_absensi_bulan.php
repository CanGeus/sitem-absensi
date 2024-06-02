<?php
// include file koneksi ke database
include "conn.php";
session_start();

$username = $_SESSION['username'];

// Ambil tanggal dari parameter GET
$selectedDate = $_GET['tanggal'];

// Query untuk mendapatkan data absensi sesuai dengan tanggal yang dipilih
$query = "SELECT * FROM absensi JOIN karyawan on karyawan.uid=absensi.uid WHERE bulan = '$selectedDate' AND karyawan.username = '$username'";
$result = $conn->query($query);

// Membuat tabel HTML untuk menampilkan data absensi
$tableHTML = "";
while ($row = $result->fetch_assoc()) {
    // Waktu batas yang diinginkan
    $batas_masuk = strtotime("08:00:00");
    $batas_keluar = strtotime("16:00:00");
    $masuk = strtotime($row['masuk']);
    $keluar = strtotime($row['keluar']);


    // Memeriksa apakah waktu masuk lebih dari waktu batas
    if ($masuk > $batas_masuk) {
        $pesan_masuk = 'Terlambat Masuk';
        $cmasuk = 'text-danger';
    } else {
        $pesan_masuk = 'Masuk Tepat Waktu';
        $cmasuk = 'text-success';
    }

    if ($keluar > $batas_keluar) {
        $pesan_keluar = 'Pulang Tepat Waktu';
        $ckeluar = 'text-success';
    } else {
        $pesan_keluar = 'Pulang Terlalu Cepat';
        $ckeluar = 'text-danger';
    }

    $tableHTML .= "<tr><td>" . $row['tanggal'] . "</td><td>" . $row['masuk'] . "</td><td>" . $row['keluar'] . "</td><td class='text-right " . $cmasuk . "'>" . $pesan_masuk . "</td><td class='text-left " . $ckeluar . "'>" . $pesan_keluar . "</td></tr>";
}
$tableHTML .= "";

// Mengirimkan tabel HTML sebagai respons
echo $tableHTML;
