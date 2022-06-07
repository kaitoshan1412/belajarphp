<?php

$conn = mysqli_connect( "localhost", "root", "", "belajarphp" );

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;

}

function tambah($data) {
    global $conn;
    // ambil data ditiap elemen
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // Upload gambar
    $gambar = upload();
    if( !$gambar ) {
        return false;
    }

    // Query
    $query = "INSERT INTO mahasiswa VALUES (' ', '$nim', '$nama', '$email', '$jurusan', '$gambar')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek ketersediaan gambar
    if( $error === 4 ) {
        echo "
                <Script>
                    alert('Pilih gambar terlebih dahulu!');
                </script>
            ";
        return false;
    }

    // cek kebenaran gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'bmp', 'img' ];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
                <Script>
                    alert('Format tidak mendukung!');
                </script>
            ";
        return false;
    }

    // jika ukuran terlalu besar
    
    if( $ukuranFile > 5000000 ) {
        echo "
                <Script>
                    alert('Ukuran terlalu besar!');
                </script>
            ";
        return false;
    }

    // generate nama acak
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar; 

    // siap upload
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru );
    return $namaFileBaru;

}


function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;
    // ambil data ditiap elemen
    $id = $data["id"];
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // pembaharuan
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek user baru
    if($_FILES['gambar']['error'] === 4 ) {
        $gambar = $gambarLama;

    } else {
        $gambar = upload();
    }

    // Query
    $query = "UPDATE mahasiswa SET nim = '$nim', nama = '$nama', email = '$email', jurusan = '$jurusan', gambar = '$gambar' WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $query = "SELECT * FROM mahasiswa WHERE nim LIKE '%$keyword%' OR nama LIKE '%$keyword%'OR email LIKE '%$keyword%' OR jurusan LIKE '%$keyword%' ";
    return query($query);
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek kesamaan pass
    if( $password !== $password2 ) {
        echo "<script>
                alert('Password tidak sesuai!')
                </script>";
        return false;
    }

    // Cek redudansi user
    $result = mysqli_query($conn, " SELECT username FROM user WHERE username = '$username' ");

    if(mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah ada')
                </script>";
        return false;
    }


    // Enkripsi
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambah user
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);


}

?>