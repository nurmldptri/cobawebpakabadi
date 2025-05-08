<?php
session_start();
include 'koneksi.php';

// Cek apakah pengguna sudah login  
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: ../login.php");
    exit();
}

// Tambah pengguna  
if (isset($_POST['add_user'])) {
    $nama_pengguna = $_POST['nama_pengguna'];
    $email = $_POST['email'];
    $password = 123;

    $sql = "INSERT INTO pengguna (nama_pengguna, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nama_pengguna, $email, $password);
    $stmt->execute();
    header("Location: manajemen_pengguna.php");
}

// Edit pengguna  


if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM pengguna WHERE id_pengguna = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}


// Update pengguna  
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $nama_pengguna = $_POST['nama_pengguna'];
    $email = $_POST['email'];

    $sql = "UPDATE pengguna SET nama_pengguna=?, email=? WHERE id_pengguna=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nama_pengguna, $email, $id);
    $stmt->execute();
    header("Location: manajemen_pengguna.php");
}

// Hapus pengguna  
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM pengguna WHERE id_pengguna=$id");
    header("Location: manajemen_pengguna.php");
}

// Ambil data pengguna  
$sql = "SELECT * FROM pengguna";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            background: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <?php include 'menu.php'; ?>
    </div>

    <div class="content">

        <div class="container mt-4">
            <h1>Manajemen Pengguna</h1>

            <!-- Form untuk menambah atau mengedit pengguna -->
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?php if (isset($user) && is_array($user)) {
                                                            echo $user['id_pengguna'];
                                                        } else {
                                                            echo '';
                                                        } ?>">

                <div class="form-group">
                    <label for="nama_pengguna">Nama Pengguna</label>
                    <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" required value="<?= (isset($user) && is_array($user)) ? $user['nama_pengguna'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= (isset($user) && is_array($user)) ? $user['email'] : ''; ?>">
                </div>
                <?php if (!isset($user)): ?>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password" required>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary" name="<?= (isset($user) && is_array($user)) ? 'update_user' : 'add_user'; ?>">
                    <?= (isset($user) && is_array($user)) ? 'Update Pengguna' : 'Tambah Pengguna'; ?>
                </button>
                <?php if (isset($user) && is_array($user)): ?>
                    <a href="manajemen_pengguna.php" class="btn btn-secondary">Batal</a>
                <?php endif; ?>
            </form>
            <a class="nav-link" href="#"><?php //echo $_SESSION['nama_pengguna']; 
                                            ?></a>
            <?php
            if (isset($user)) {
                // echo "Variabel \$user sudah didefinisikan.";
            } else {
                //echo "Variabel \$user belum didefinisikan.";
            }
            //unset($user);
            ?><br><?php
                    // var_dump($_GET); 
                    ?><br><?php
                            //       var_dump($user);
                            ?>

            <hr>

            <h2>Daftar Pengguna</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id_pengguna']; ?></td>
                                <td><?php echo $row['nama_pengguna']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                    <a href="manajemen_pengguna.php?edit=<?php echo $row['id_pengguna']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="manajemen_pengguna.php?delete=<?php echo $row['id_pengguna']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data pengguna</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>