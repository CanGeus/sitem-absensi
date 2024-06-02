<?php
header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber

include("conn.php"); // Pastikan file conn.php berisi koneksi ke database

// Memeriksa apakah ada data yang dikirimkan melalui metode POST
if (!empty($_GET['uid'])) {
    $uid = $_GET['uid'];

    // Membuat query untuk menyisipkan data ke dalam tabel
    $sql = "UPDATE karyawan SET username = NULL, nama = NULL, jk= NULL, alamat= NULL, password = NULL, email = NULL WHERE uid = '$uid'";

    if ($conn->query($sql) === TRUE) {
        // Redirect setelah operasi query berhasil
        header("Location: ../admin/karyawan.php?pesan=Data berhasil dihapus&uid=" . $uid);
        exit;
    } else {
        // Tanggapan jika terjadi kesalahan dalam query
        $response = array("status" => "error", "message" => "Gagal memperbarui data karyawan: " . $conn->error);
        echo json_encode($response);
    }
} else if (empty($_GET['uid'])) {
    // Tanggapan jika metode request tidak valid
    $response = array("status" => "error", "message" => "Metode request tidak valid");
    echo json_encode($response);
}

// Tutup koneksi
$conn->close();
