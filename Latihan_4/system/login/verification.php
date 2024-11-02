<?php
session_start();

try{
    require_once '../../koneksi.php';

    if($_SERVER['REQUEST_METHOD'] != "POST") {
        throw new Exception("Request Method tidak sesuai");            
    }

    if(!isset($_POST['username']) || empty($_POST['username'])) {
        throw new Exception("Username tidak ditemukan");        
    }
    
    if(!isset($_POST['password']) || empty($_POST['password'])) {
        throw new Exception("Password tidak ditemukan");        
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param('ss', $username, $password);

    if(!$stmt->execute()) {
        throw new Exception("Gagal Eksekusi Kueri");        
    } else {
        $_SESSION['LOGGED_IN'] = true;
        header("Location: ../../index.php");
        exit;
    }

}catch(Exception $e) {
    echo "Error:". $e->getMessage();
}