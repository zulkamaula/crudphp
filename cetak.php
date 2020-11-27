<?php

require_once __DIR__ . '/vendor/autoload.php';

require 'functions.php';
$mahasiswa = query("SELECT * FROM mahasiswa");

$mpdf = new \Mpdf\Mpdf();
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mahasiswa</title>
    <link rel="shortcut icon" href="img/ICON.png">
    <link rel="stylesheet" href="css/print.css">
</head>
<body>
    <h1>Daftar Mahasiswa</h1>

    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>No.</th>
                <th>Gambar</th>
                <th>NPM</th>
                <th>Nama</th>
                <th>E-Mail</th>
                <th>Jurusan</th>
        </tr>';

$i = 1;
foreach ($mahasiswa as $row) {
    $html .= '<tr>
    <td>' . $i++ . '</td>
    <td><img src="img/' . $row["gambar"] . '" width="50">
    <td>' . $row["npm"] . '</td>
    <td>' . $row["nama"] . '</td>
    <td>' . $row["email"] . '</td>
    <td>' . $row["jurusan"] . '</td>
    </tr>';
}

// cara di bawah adalah penggabungan string dari string sebelumnya dengan titik.

$html .= '</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('Daftar-Mahasiswa.pdf', 'I');
