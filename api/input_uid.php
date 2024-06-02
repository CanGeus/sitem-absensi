<?php
header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber

include("conn.php"); // Pastikan file conn.php berisi koneksi ke database

// Memeriksa apakah ada data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $uid = $_POST['uid'];

    $cek_uid = "SELECT * FROM karyawan WHERE uid = '$uid'";

    if ($conn->query($cek_uid)->num_rows == 0) {

        // Membuat query untuk menyisipkan data ke dalam tabel
        $sql = "INSERT INTO karyawan (uid) VALUES ('$uid')";

        if ($conn->query($sql) === TRUE) {
            echo "Data berhasil disisipkan";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "RFID Sudah Terdaftar";
    }
} else {
    echo "REQUEST METHOD SALAH !!!";
}

// Tutup koneksi
$conn->close();
