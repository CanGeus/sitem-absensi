<?php
header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber

include("conn.php"); // Pastikan file conn.php berisi koneksi ke database

// Set zona waktu ke Jakarta
date_default_timezone_set('Asia/Jakarta');

// Mendapatkan tanggal dan waktu sekarang di Jakarta
$tanggal = date("Y-m-d");
$tahun = date("Y");
$bulan = date("F");
$tgl = date("d");
// $tanggal = "2024-03-30";


function get_keterangan($uid, $status)
{
    include("conn.php");
    $tanggal = date("Y-m-d");
    $query = "SELECT * FROM karyawan WHERE uid = '$uid'";
    $result = $conn->query($query);

    if ($status == "Sudah") {

        $row = $result->fetch_object();
        $nama = $row->nama;
        echo $nama . ' Hari ini ' . $tanggal . ' Sudah Presensi Masuk dan Keluar';
    } else {
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nama = $row["nama"];
            echo $nama . ' Berhasil Absensi ' . $status;
        } else {
            echo json_encode(array('hasDataRetrieved' => false));
        }
    }
}

// Memeriksa apakah ada data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Mendapatkan nilai dari form
    $uid = $_GET['uid'];
    $jamuid = date('H:i:s');

    if ($conn->query("SELECT * FROM karyawan WHERE uid = '$uid'")->num_rows == 1) {

        $cek_uid = "SELECT * FROM absensi WHERE uid = '$uid'";

        // cek uid sudah ada atau belum
        if ($conn->query($cek_uid)->num_rows == 0) {
            // Membuat query untuk menyisipkan data ke dalam tabel
            $sql = "INSERT INTO absensi (uid, tanggal, masuk, tahun, bulan, tgl) VALUES ('$uid', '$tanggal', '$jamuid', '$tahun', '$bulan', '$tgl')";

            if ($conn->query($sql) === TRUE) {

                get_keterangan($uid, 'Masuk');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else if ($conn->query($cek_uid)->num_rows !== 0) {
            $cek_tanggal = "SELECT * FROM absensi WHERE tanggal = '$tanggal'AND uid = '$uid' ORDER BY id DESC LIMIT 1";
            $cek_tanggal_NULL = "SELECT * FROM absensi WHERE uid = '$uid' AND tanggal = '$tanggal' AND keluar is NULL ORDER BY id DESC LIMIT 1";
            if ($conn->query($cek_tanggal_NULL)->num_rows > 0) {
                $jam_keluar = "UPDATE absensi SET keluar = '$jamuid' WHERE tanggal = '$tanggal' AND uid = '$uid'";
                if ($conn->query($jam_keluar) === TRUE) {

                    get_keterangan($uid, 'Keluar');

                    // echo "Data berhasil disisipkan";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                // echo "data ada";
            } else if ($conn->query($cek_tanggal)->num_rows == 0) {
                // Membuat query untuk menyisipkan data ke dalam tabel
                $sql = "INSERT INTO absensi (uid, tanggal, masuk, tahun, bulan, tgl) VALUES ('$uid', '$tanggal', '$jamuid', '$tahun', '$bulan', '$tgl')";

                if ($conn->query($sql) === TRUE) {


                    get_keterangan($uid, 'Masuk');

                    // echo "Data berhasil disisipkan";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                http_response_code(400);
                get_keterangan($uid, 'Sudah');
            }
        }
    } else {
        echo "RDIF Belum terdaftar";
    }
} else {
    echo "REQUEST METHOD SALAH !!!";
}


// Tutup koneksi
$conn->close();
