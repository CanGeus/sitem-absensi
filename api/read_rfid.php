<?php

header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber

include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Mendapatkan nilai dari form
    $uid = $_GET['uid'];


    // Query untuk mengambil data dari database
    $sql = "SELECT * FROM karyawan WHERE uid = '$uid'"; // Ganti 'nama_tabel' dengan nama tabel Anda

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
        http_response_code(400);
    }
} else {
    echo "REQUEST METHOD SALAH !!!";
}

// Menutup koneksi
$conn->close();
