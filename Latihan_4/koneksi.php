<?php

$conn = new mysqli("localhost", "root", "", "lsp_4");

if($conn->connect_error) {
    die("Koneksi Gagal");
}
// else {
//     echo "Koneksi Berhasil";
// }