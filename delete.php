<?php 
    session_start();

    //Cek apakah user udah login, jika belum arahkan ke halaman login
    if(!isset($_SESSION["login"])){
        header("Location: login.php");
        exit;
    }
    
    require 'functions.php';

    $id = $_GET["id"];

    if( delete($id) > 0){
        echo "
                <script>
                    alert('mahasiswa berhasil dihapus');
                    document.location.href = 'index.php';
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('mahasiswa gagal dihapus <?= mysqli_error($conn)?>');
                    document.location.href = 'index.php';
                </script>
            ";
    }
?>