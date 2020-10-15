<?php
session_start();

//Cek apakah user udah login, jika belum arahkan ke halaman login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$id = $_GET["id"];

$mhs = query("SELECT * FROM mahasiswa WHERE id= $id")[0];

//Cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

    //Cek apakah data berhasil ditambahkan
    if (edit($_POST, $id, $gambarLama) > 0) {
        echo "
                <script>
                    alert('mahasiswa berhasil diubah');
                    document.location.href = 'index.php';
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('mahasiswa gagal diubah <?= mysqli_error($conn)?>');
                    document.location.href = 'index.php';
                </script>
            ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Mahasiswa</title>
</head>

<body>
    <h1>Ubah Data Mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required value="<?= $mhs["nama"] ?>">
            </li>
            <li>
                <label for="nim">NIM :</label>
                <input type="text" name="nim" id="nim" required value="<?= $mhs["nim"] ?>">
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" required value="<?= $mhs["jurusan"] ?>">
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required value="<?= $mhs["email"] ?>">
            </li>
            <li>
                <?php $gambarLama = $mhs["gambar"] ?>
                <label for="gambar">Gambar :</label> <br>
                <img src="img/<?= $mhs["gambar"] ?>" alt="" width="60"> <br>
                <input type="file" name="gambar" id="gambar" required>
            </li>
            <li>
                <button type="submit" name="submit"> Edit! </button>
            </li>
        </ul>
    </form>
</body>

</html>