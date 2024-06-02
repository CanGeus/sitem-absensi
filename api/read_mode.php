<?php

header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber

include("conn.php");

// Query untuk mengambil data dari database
$sql = "SELECT kondisi FROM mode"; // Ganti 'nama_tabel' dengan nama tabel Anda

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Menginisialisasi array untuk menyimpan data
    $data = array();

    // Mendapatkan hasil query sebagai array asosiatif
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Mengubah data menjadi format JSON
    $json_response = json_encode($data);

    // Mengirimkan response JSON
    header('Content-Type: application/json');
    echo $json_response;
} else {
    // Jika tidak ada data yang ditemukan
    echo "Tidak ada data yang ditemukan.";
}
