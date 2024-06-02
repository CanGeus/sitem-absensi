<?php
header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber

include("conn.php"); // Pastikan file conn.php berisi koneksi ke database

// Memeriksa apakah ada data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form dan membersihkan data
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $jk = mysqli_real_escape_string($conn, $_POST['jk']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Membuat query untuk menyisipkan data ke dalam tabel
    $sql = "UPDATE karyawan SET nama = '$nama', email = '$email', alamat = '$alamat', jk = '$jk' WHERE uid = '$uid'";

    if ($conn->query($sql) === TRUE) {
        // Redirect setelah operasi query berhasil
        header("Location: ../admin/karyawan.php");
        exit;
    } else {
        // Tanggapan jika terjadi kesalahan dalam query
        $response = array("status" => "error", "message" => "Gagal memperbarui data karyawan: " . $conn->error);
        echo json_encode($response);
    }
} else {
    // Tanggapan jika metode request tidak valid
    $response = array("status" => "error", "message" => "Metode request tidak valid");
    echo json_encode($response);
}

// Tutup koneksi
$conn->close();
