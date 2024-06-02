<?php
header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber

include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tanggal'])) {
    $tanggal = $_POST['tanggal'];
    $query = "SELECT * FROM absensi JOIN karyawan ON karyawan.uid=absensi.uid WHERE bulan = '$tanggal'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Misalnya waktu masuk dari $row['masuk']
            $waktu_masuk = $row['masuk'];
            $waktu_keluar = $row['keluar'];

            // Mengonversi waktu masuk ke representasi waktu UNIX
            $waktu_unix_masuk = strtotime($waktu_masuk);
            $waktu_unix_keluar = strtotime($waktu_keluar);

            // // Inisialisasi jam kerja dengan nilai default
            // $jam_kerja = '';

            // // Memeriksa apakah waktu masuk dan keluar valid sebelum menghitung jam kerja
            // if ($waktu_unix_keluar !== false && $waktu_unix_masuk !== false) {
            //     // Menghitung jam kerja dalam detik
            //     $jam_kerja = ($waktu_unix_keluar - $waktu_unix_masuk);
            //     // Menghitung jumlah jam
            //     $jam = floor($jam_kerja / 3600);

            //     // Menghitung sisa detik setelah dihitung sebagai jam
            //     $sisa_detik = $jam_kerja % 3600;

            //     // Menghitung jumlah menit
            //     $menit = floor($sisa_detik / 60);
            // }


            // Waktu batas yang diinginkan
            $batas_masuk = strtotime("08:00:00");
            $batas_keluar = strtotime("16:00:00");

            // Memeriksa apakah waktu masuk lebih dari waktu batas
            if ($waktu_unix_masuk > $batas_masuk) {
                $masuk = '<td class="text-danger">' . $row['masuk'] . "</td>";
            } else {
                $masuk = "<td>" . $row['masuk'] . "</td>";
            }

            if ($waktu_unix_keluar < $batas_keluar) {
                $keluar = '<td class="text-danger">' . $row['keluar'] . "</td>";
            } else {
                $keluar = "<td>" . $row['keluar'] . "</td>";
            }

            // Output baris tabel dengan data yang sudah diperiksa
            echo "<tr>
        <td>" . $row['nama'] . "</td>
        <td>" . $row['uid'] . "</td>
        <td>" . $row['tanggal'] . "</td>"
                . $masuk .
                $keluar . "
        <td>
        <a href='absen_karyawan_uid.php?uid=" . $row['uid'] . "'>
            <div class='badge badge-outline-success'>Semua Data</div>
        </a>
        </td>
    </tr>";
        }
    } else {
        echo "Tidak ada data pada tanggal tersebut.";
    }
}
