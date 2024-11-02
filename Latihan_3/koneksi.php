<?php

$conn = new mysqli("localhost", "root", "", "lsp_3");

if($conn->connect_error) {
    die("Koneksi Gagal");
}

// else {
//     echo "Koneksi Berhasil";
// }