<?php
// Koneksi ke database
// untuk paramaternya diisi dengan ("nama host", "username (default)", "password (kosong krna defaultnya)", "nama databasenya")
$conn = mysqli_connect("localhost", "root", "", "phpdasar");
// masukkan printah connect ke dlm variabel buatan sendiri agar saat auto update perubahan dari databasenya sperti sintak diatas

// ambil data dari tabel yg ada di database phpdasar yaitu tabel mahasiswa/ query data nya dgn menggunakan function sprt dibawah.
// $result = mysqli_query($conn, "SELECT * FROM mahasiswa");
// untuk mengecek apakah error / tidak
// var_dump($result);

// atau bisa dgn cara spt di bawah :
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ){
        $rows[] = $row;
    }
    return $rows;
}

// ambil data (fetch) dari db mahasiswa dari object resukt 
/* 
    ada 4 cara :
        mysqli_fetch_row() // mengembalikan array numeric
        mysqli_fetch_assoc() // mengembalikan array associative
        mysqli_fetch_array() // mengembalikan keduanya (numeric & assosiative)
        mysqli_fetch_object()
 */


function tambah( $data_tambah ){
    global $conn;

    $npm = htmlspecialchars ( $data_tambah["npm"] );
    $nama = htmlspecialchars ( $data_tambah["nama"] );
    $email = htmlspecialchars ( $data_tambah["email"] );
    $jurusan = htmlspecialchars ( $data_tambah["jurusan"] );
    
    // buat fungsi upload gambar
    $gambar = upload();
    if ( !$gambar ) {
        return false;
    }

    // mengambil data
    $query = "INSERT INTO mahasiswa
                VALUES
                ('', '$npm', '$nama', '$email', '$jurusan', '$gambar')
                ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows( $conn );
}

function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang di upload
    if( $error === 4 ) {
        echo "<script>
            alert('Pilih gambar terlebih dahulu!');
            </script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.', $namaFile);
    // explode itu adlh sebuah fungsi untuk memecah sebuah string menjadi array yg menggunakan 'delimiter'
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if ( !in_array( $ekstensiGambar, $ekstensiGambarValid ) ){
        echo "<script>
                alert('Yang anda upload bukan gambar!');
                </script>";
        return false;
    }

    // cek jika ukuran terlalu besar dari aturan yang kita buat
    if ($ukuranFile > 1000000 ) {
        echo "<script>
                alert('Ukuran gambar terlalu besar!');
                </script>";
        return false;
    }

    // jika lolos pengecekan, gambar siap di upload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function ubah($data_ubah){
    global $conn;

    $id = $data_ubah["id"];
    $npm = htmlspecialchars ( $data_ubah ["npm"] );
    $nama = htmlspecialchars ( $data_ubah ["nama"] );
    $email = htmlspecialchars ( $data_ubah ["email"] );
    $jurusan = htmlspecialchars ( $data_ubah ["jurusan"] );
    
    $gambarLama = ( $data_ubah ["gambarLama"] );
    
    // cek apakah user pilih gambar baru atau tidak
    if( $_FILES['gambar']['error'] === 4 ){
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    // mengambil data
    $query = "UPDATE mahasiswa SET 
                npm = '$npm',
                nama = '$nama',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
            WHERE id = $id;

            ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows( $conn );
}


function cari($keyword){
    $query = "SELECT * FROM mahasiswa
                WHERE
                nama LIKE '%$keyword%' OR
                npm LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%'
                -- dengan menggunakan keyword SQL yaitu LIKE diringi dengan menambahkan tanda % dalam argumen tujuan AGAR MENCARI DENGAN FLEKSIBEL..
            ";
    return query($query);
}

function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if(mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username sudah terdaftar..');
            </script>";
        return false;
    }



    // cek konfirmasi password
    if( $password !== $password2 ){
        echo "<script>
                alert('konfirmasi password tidak sesuai!');
            </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('','$username','$password')");

    return mysqli_affected_rows($conn);




}

?>