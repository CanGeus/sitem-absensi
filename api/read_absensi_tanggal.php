<?php
// include file koneksi ke database
include "conn.php";

// Ambil tanggal dari parameter GET
$selectedDate = $_GET['tanggal'];

// Query untuk mendapatkan data absensi sesuai dengan tanggal yang dipilih
$query = "SELECT * FROM absensi JOIN karyawan on karyawan.uid=absensi.uid WHERE tanggal = '$selectedDate' AND karyawan.nama IS NOT NULL";
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
    } else {
        $pesan_masuk = 'Masuk Tepat Waktu';
    }

    if ($keluar > $batas_keluar) {
        $pesan_keluar = 'Pulang Tepat Waktu';
    } else {
        $pesan_keluar = 'Pulang Terlalu Cepat';
    }

    $tableHTML .= "<tr><td>" . $row['nama'] . "</td><td>" . $row['masuk'] . "</td><td>" . $row['keluar'] . "</td><td class='text-center'>" . $pesan_masuk . "   |   " . $pesan_keluar . "</td></tr>";
}
$tableHTML .= "";

// Mengirimkan tabel HTML sebagai respons
echo $tableHTML;
