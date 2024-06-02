<?php
include('api/conn.php');

// Ambil data dari database
$sql = "SELECT * FROM karyawan";
$result = $conn->query($sql);

// Simpan data dalam array
$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Tutup koneksi
$conn->close();

// Kirim data ke Google Apps Script
$url = "https://script.google.com/macros/s/AKfycbwwppsL-WhXI43vyVztjLbdTxY8lRqH__qfyooKZn8P83Ca3bal5lcBYzeHCKpkU9qXMA/exec";
$data_json = json_encode($data);
$options = array(
    'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-Type: application/json',
        'content' => $data_json
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// Tampilkan hasil
echo $result;
