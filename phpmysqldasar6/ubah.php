<?php
require 'functions.php';

$id = $_GET["id"];

$bio = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

if( isset($_POST["submit"]) ) {
    // Cek keberhasilan
    if( ubah($_POST) > 0 ) {
        echo "
                <Script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'index.php';
                </script>
             ";
    } else {
        echo "
                <Script>
                    alert('Data gagal diubah!');
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman ubah data</title>
</head>
<body>
    <h1>Ubah data mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $bio["id"] ?>">
        <input type="hidden" name="gambarLama" value="<?= $bio["gambar"] ?>">

        <ul>
            <li>
                <label for="nim">NIM: </label>
                <input type="disabled" name="nim" id="nim" required value="<?= $bio["nim"]; ?>">
            </li>
            <li>
                <label for="nama">Nama: </label>
                <input type="text" name="nama" id="nama" required value="<?= $bio["nama"]; ?>">
            </li>
            <li>
                <label for="email">Email: </label>
                <input type="text" name="email" id="email" required value="<?= $bio["email"]; ?>">
            </li>
            <li>
                <label for="jurusan">Jurusan: </label>
                <input type="text" name="jurusan" id="jurusan" required value="<?= $bio["jurusan"]; ?>">
            </li>
            <li>
                <label for="gambar">Gambar: </label> <br>
                <img src="img/<?= $bio["gambar"]; ?>" width="40"> <br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah data!</button>
            </li>
        </ul>
    </form>
</body>
</html>