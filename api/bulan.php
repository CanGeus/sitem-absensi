<?php

header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber
include "conn.php";

$query = "SELECT DISTINCT bulan FROM absensi LIMIT 12";
$result = $conn->query($query);

$dates = array();
while ($row = $result->fetch_assoc()) {
    $dates[] = $row['bulan'];
}

$json_response = json_encode($dates);

// Mengirimkan response JSON
header('Content-Type: application/json');
echo $json_response;
