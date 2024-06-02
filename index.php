<?php
include("api/conn.php");
session_start();

// Cek jika pengguna sudah login, maka redirect ke halaman index
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 0) {
        header("Location: karyawan");
    } else if ($_SESSION['role'] == 1) {
        header("Location: admin");
    }
    exit;
}


// Form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa keberadaan pengguna
    $query = "SELECT * FROM karyawan WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_object();
        $role = $row->role;
        // Jika pengguna ada, buat sesi dan arahkan ke halaman index
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['uid'] = $row->uid;
        if ($role == false) {
            header("Location: karyawan");
        } else if ($role == true) {
            header("Location: admin");
        }
        exit;
    } else {
        // Jika tidak, tampilkan pesan error
        $error = "Username atau password salah.";
    }
}


?>

<!doctype html>
<html lang="en">

<?php include("templates/head.php") ?>

<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-image: url(assets/img/jan-sendereks.jpg);
        background-repeat: no-repeat;
        background-size: cover;
    }

    .card {
        border: solid 1px black;
        width: 25rem;
        padding: 2rem 1rem;
    }
</style>

<body>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h3 class="title text-center">Login</h3>
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" placeholder="Enter Username" name="username" required htmlspecialchars>
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required htmlspecialchars>
                </div>
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>


        </div>
    </div>


</body>

</html>