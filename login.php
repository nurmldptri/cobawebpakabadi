<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM pengguna WHERE email = ?";
    //Query tersebut mencari semua data dari tabel pengguna berdasarkan kolom email. 
    //Tanda ? digunakan sebagai placeholder, yang nantinya diisi dengan variabel.

    $stmt = $conn->prepare($sql); //Query disiapkan menggunakan prepare() agar lebih aman dari SQL Injection.
    $stmt->bind_param("s", $email); //menunjukkan bahwa parameter yang diberikan berupa string.
    $stmt->execute(); //Query dieksekusi.
    $result = $stmt->get_result(); //Data hasil pencarian disimpan dalam var $result untuk diproses lebih lanjut.

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) {
            $_SESSION['id_pengguna'] = $user['id_pengguna'];
            $_SESSION['nama_pengguna'] = $user['nama_pengguna'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('path/to/your/background-image.jpg');
            /* Ganti dengan path gambar background Anda */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.9);
            /* Transparan untuk melihat background */
        }

        .login-title {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .login-icon {
            font-size: 50px;
            color: #007bff;
        }

        .logo {
            width: 100px;
            /* Sesuaikan ukuran logo */
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container login-container col-md-4">
        <div class="text-center">
            <h2>LOGIN</h2>
        </div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <kbd class="bg-light text-dark">Silahkan masukkan email dan password untuk Login</kbd>
            <span class="badge badge-secondary">Secondary</span>
            </br>
            <button type="submit" class="btn btn-primary btn-block btn-block">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>