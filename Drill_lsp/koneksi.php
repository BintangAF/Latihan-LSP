<?php

$conn = new mysqli("localhost", "root", "", "drill_lsp");

if($conn->connect_error) {
    die("koneksi gagal");
}

// else {
//     echo"koneksi berhasil";
// }