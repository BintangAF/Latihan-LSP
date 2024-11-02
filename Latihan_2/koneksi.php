<?php

$conn = new mysqli("localhost", "root", "", "lsp_2");

if($conn->connect_error) {
    die("koneksi gagal");
}
// else {
//     echo "koneksi berhasil";
// }