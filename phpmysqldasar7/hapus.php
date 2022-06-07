<?php

session_start();
if( !$_SESSION["login"]) {
    header("Location: login.php");
}

require 'functions.php';

$id = $_GET["id"];

if( hapus($id) > 0 ) {
    echo "
                <Script>
                    alert('Data berhasil dihapus!');
                    document.location.href = 'index.php';
                </script>
             ";
    } else {
        echo "
                <Script>
                    alert('Data gagal dihapus!');
                    document.location.href = 'index.php';
                </script>
            ";
}

?>