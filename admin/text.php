<?php session_start();

// Cek jika pengguna belum login, maka redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Tanggal</title>
</head>

<body>

    <select id="selectTanggal">
        <option value="">Pilih Tanggal</option>
    </select>

    <script>
        // Mengambil data dari tanggal.php menggunakan AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var dates = JSON.parse(this.responseText); // Menguraikan respons JSON
                var select = document.getElementById("selectTanggal");

                // Mengisi elemen select dengan opsi dari data JSON
                dates.forEach(function(date) {
                    var option = document.createElement("option");
                    option.value = date;
                    option.text = date;
                    select.appendChild(option);
                });
            }
        };
        xhr.open("GET", "../api/tanggal.php", true);
        xhr.send();
    </script>

</body>

</html>