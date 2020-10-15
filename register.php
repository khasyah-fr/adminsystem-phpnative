<?php 
require 'functions.php';

if( isset($_POST["register"])){
    if (register($_POST) > 0){
        echo "
            <script>
                alert('user berhasil register');
                document.location.href = 'login.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('user gagal register <?= mysqli_error($conn)?>');
                document.location.href = 'login.php';
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
    <title>Registration Page</title>
</head>
<body>
    <h1>Registration Page</h1>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username: </label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <label for="confirmation">Confirmation Password: </label>
                <input type="password" name="confirmation" id="confirmation">
            </li>
            <li>
                <button type="submit" name="register">Register!</button>
            </li>
        </ul>
    </form>
</body>
</html>