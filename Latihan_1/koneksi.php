<?php

$conn = new mysqli("localhost", "root", "", "lsp");

if($conn->connect_error) {
    die('koneksi gagal' .  $conn->connect_error);
}
//  else {
//     echo "Koneksi berhasil";
// }
