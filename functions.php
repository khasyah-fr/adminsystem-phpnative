<?php 
//Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpwebunpas");

//Query data ke database
function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function create($data){
    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $nim = htmlspecialchars($data["nim"]); 
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email = htmlspecialchars($data["email"]);
    
    $gambar = upload();
    if(!$gambar){
        return false;
    }

    $query = "INSERT INTO mahasiswa VALUES ('', '$nama', '$nim', '$jurusan', '$email', '$gambar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload(){

    $namaFile = $_FILES["gambar"]["name"];
    $ukuranFile = $_FILES["gambar"]["size"];
    $error = $_FILES["gambar"]["error"];
    $tmpName = $_FILES["gambar"]["tmp_name"];

    //Jika gambar gagal diupload (value error selain 0), maka mahasiswa gagal ditambahkan
    if($error !== 0){
        return false;
    }

    //Apakah gambar yang diupload sesuai ekstensi nya
    $ekstensiGambarValid = ["jpg", "jpeg", "png"];

    $ekstensiGambarUpload = explode(".", $namaFile);
    $ekstensiGambarUpload = strtolower(end($ekstensiGambarUpload));

    if( !in_array($ekstensiGambarUpload, $ekstensiGambarValid)){
        return false;
    }

    //Cek ukuran gambar tidak lebih besar dari 2MB
    if($ukuranFile > 2000000){
        return false;
    }

    //Cegah nama file gambar upload yang sama
    $namaFileBaru = uniqid();
    $namaFileBaru .= ".";
    $namaFileBaru .= $ekstensiGambarUpload;

    //Lolos pengecekan, siap diupload
    move_uploaded_file($tmpName, "img/" . $namaFileBaru);

    return $namaFileBaru;
}

function delete($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    
    return mysqli_affected_rows($conn);
}

function edit($data, $id, $gambarLama) {
    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $nim = htmlspecialchars($data["nim"]); 
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email = htmlspecialchars($data["email"]);

    //Cek gambar mana yang mau diupload, gambar lama atau gambar baru diupload
    if($_FILES["gambar"]["error"] === 4){
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE mahasiswa SET 
            nama = '$nama',
            nim = '$nim',
            jurusan = '$jurusan',
            email = '$email',
            gambar = '$gambar'
            WHERE id = $id
        ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function search($keyword){
    $query = "SELECT * FROM mahasiswa
                WHERE nama LIKE '%$keyword%' OR 
                nim LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%' OR
                email LIKE '%$keyword%' 
            ";
    return query($query);
}

function register($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = $data["password"];
    $confirmationpassword = $data["confirmation"];

    //Check username sudah ada di database atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username= '$username'");
    if( mysqli_fetch_assoc($result) ){
        return false;
    }

    //Check apakah password dan confirmation sama
    if($password !== $confirmationpassword){
        return false;
    }

    //Enkripsi Password
    $password = password_hash($password, PASSWORD_DEFAULT);


    //Tambahkan user ke database
     mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

     return mysqli_affected_rows($conn);
}

?>