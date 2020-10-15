<?php 
    session_start();

    //Cek apakah user udah login, jika belum arahkan ke halaman login
    if(!isset($_SESSION["login"])){
        header("Location: login.php");
        exit;
    }
    
    require 'functions.php';


    //Cek apakah tombol submit sudah ditekan atau belum
    if(isset($_POST["submit"])){
        
        //Cek apakah data berhasil ditambahkan
        if(create($_POST) > 0) {
            echo "
                <script>
                    alert('mahasiswa berhasil ditambahkan');
                    document.location.href = 'index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('mahasiswa gagal ditambahkan <?= mysqli_error($conn)?>');
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
    <title>Tambah Data Mahasiswa</title>
</head>
<body>
    <h1>Tambah Data Mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama">Nama          :</label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="nim">NIM            :</label>
                <input type="text" name="nim" id="nim" required>
            </li>
            <li>
                <label for="jurusan">Jurusan    :</label>
                <input type="text" name="jurusan" id="jurusan" required>
            </li>
            <li>
                <label for="email">Email        :</label>
                <input type="text" name="email" id="email" required>
            </li>
            <li>
                <label for="gambar">Gambar(jpg, jpeg, png)(Ukuran Gambar dibawah 2MB)      :</label>
                <input type="file" name="gambar" id="gambar" required>
            </li>
            <li>
                <button type="submit" name="submit"> Create! </button>
            </li>
        </ul>
    </form>
</body>
</html>