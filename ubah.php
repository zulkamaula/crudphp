<?php

session_start();
// cek session
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// koneksin ke database sudah di dalkukan dlm function.php dgn menghubungkan dg require.
require 'functions.php';

// ambil data di URL dgn GET
$id = $_GET["id"];

// query data mahasiswa berdasarkan id-nya
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];



// cek apakah tombol submit sudah di tekan atau belum
if (isset($_POST["submit"])) {

    // ambil data dari tiap elemen form yg disimpan di functions.php

    // query insert data di simpan dalam function.php 

    // mengecek apakah data berhasil diubah atau tidak dg sintak di bawah ini
    if (ubah($_POST) > 0) {
        echo "
        // memunculka alert dg javascript untuk berpindah halaman.

            <script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>

        ";
    } else {
        echo "
            <script>
                alert('Data gagal diubah!');
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
    <title>Ubah Data Mahasiswa</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container-ubah">
        <h1>Ubah Data Mahasiswa</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
            <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"]; ?>">

            <ul>
                <li>
                    <label for="npm">NPM :</label>
                    <input type="text" name="npm" id="npm" required value=<?= $mhs["npm"]; ?>>
                </li>

                <li>
                    <label for="nama">Nama :</label>
                    <input type="text" name="nama" id="nama" required value=<?= $mhs["nama"]; ?>>
                </li>

                <li>
                    <label for="email">E-mail :</label>
                    <input type="text" name="email" id="email" required value=<?= $mhs["email"]; ?>>
                </li>

                <li>
                    <label for="jurusan">Jurusan :</label>
                    <input type="text" name="jurusan" id="jurusan" required value=<?= $mhs["jurusan"]; ?>>
                </li>

                <li class="gambar">
                    <label for="gambar">Gambar</label> <br>
                    <img src="img/<?= $mhs['gambar']; ?>" width="100"> <br>
                    <input type="file" name="gambar" id="gambar">
                </li>

                <li>
                    <button type="submit" name="submit">Ubah Data</button>
                </li>

            </ul>
        </form>
    </div>
</body>

</html>