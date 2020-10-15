<?php 
session_start();

//Cek apakah user udah login, jika belum arahkan ke halaman login
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

require 'functions.php';
$mahasiswa = query("SELECT * FROM mahasiswa");

if(isset($_POST["search"])){
    $mahasiswa = search($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
</head>
<body>
    <a href="logout.php"> Logout</a>
    <h1>Daftar Mahasiswa</h1>

    <a href="create.php"> Create New Data Mahasiswa </a>
    <br><br>

    <form action="" method="post">
        <label for="keyword"> Search Mahasiswa: </label>
        <input type="text" name="keyword" size="40" id="keyword" placeholder="Masukkan keyword pencarian" autocomplete="off">
        <button type="submit" name="search"> Cari </button>
    </form>

    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No Urut</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Jurusan</th>
            <th>Email</th>
        </tr>
        <?php $i = 1?>
        <?php foreach($mahasiswa as $row) : ?>
        <tr>
            <td><?=$i ?></td> 
            <td>
                <a href="edit.php?id=<?=$row["id"]?>"> Edit </a> |
                <a href="delete.php?id=<?=$row["id"]?>" onclick="return confirm('delete?');"> Delete </a> 
            </td>
            <td>
                <img src="img/<?=$row["gambar"] ?>" alt="<?=$row["gambar"] ?>">
            </td>
            <td><?=$row["nama"] ?></td>
            <td><?=$row["nim"] ?></td>
            <td><?=$row["jurusan"] ?></td>
            <td><?=$row["email"] ?></td>
        </tr>
        <?php $i = $i + 1?>
        <?php endforeach;?>
    </table>
</body>
</html>