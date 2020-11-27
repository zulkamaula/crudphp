<?php

session_start();
// cek session
if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
}

// koneksin ke database sudah di dalkukan dlm function.php dgn menghubungkan dg require.
require 'functions.php';

// cek apakah tombol submit sudah di tekan atau belum
if( isset($_POST["submit"]) ){

    // ambil data dari tiap elemen form yg disimpan di functions.php

    // query insert data di simpan dalam function.php 
    
    // mengecek apakah data berhasil ditambahkan atau tidak dg sintak di bawah ini
    if( tambah($_POST) > 0 ){
        echo "
        // memunculka alert dg javascript untuk berpindah halaman.

            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>

        ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan!');
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
    <style>
    ul li {
        list-style: none;
        margin: 10px auto;
    }
    </style>
</head>
<body>
    <h1>Tambah Data Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="npm">NPM :</label>
                <input type="text" name="npm" id="npm" required>
            </li>
            
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required>
            </li>

            <li>
                <label for="email">E-mail :</label>
                <input type="text" name="email" id="email" required>
            </li>

            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" required>
            </li>

            <li>
                <label for="gambar">Gambar :</label>
                <input type="file" name="gambar" id="gambar">
            </li>

            <li>
                <button type="submit" name="submit">Tambah Data</button>
            </li>

        </ul>
        </form>
</body>
</html>