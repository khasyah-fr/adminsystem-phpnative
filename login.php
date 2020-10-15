<?php 
session_start();

if(isset($_COOKIE["login"])){
    $_SESSION["login"] = true;
}

if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}

require 'functions.php';

if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    //Check username
    if(mysqli_num_rows($result) === 1){

        //Check password
        $row = mysqli_fetch_assoc($result);

        if( password_verify($password, $row["password"]) ) {
            //Set session
            $_SESSION["login"] = true;

            //cek remember me
            if(isset($_POST["remember"])){
                setcookie('login', true, time() + 3600);
            }

            header("Location: index.php");
            exit;
        }

    } else {
        echo "
            <script>
                alert('Username atau password salah');
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
    <h1>Login Page</h1>
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
                <label for="remember">Remember me:</label>
                <input type="checkbox" name="remember" id="remember">
            </li>
            <li>
                <button type="submit" name="login">Login!</button>
            </li>
        </ul>
    </form>
</body>
</html>