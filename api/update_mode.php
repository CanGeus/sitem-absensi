<?php
header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber

include("conn.php"); // Pastikan file conn.php berisi koneksi ke database

// Memeriksa apakah ada data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $mode = $_POST['mode'];

    // Membuat query untuk menyisipkan data ke dalam tabel
    $sql = "UPDATE mode SET kondisi = '$mode' WHERE id = 1";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disisipkan";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo $mode;
}

// Tutup koneksi
$conn->close();
