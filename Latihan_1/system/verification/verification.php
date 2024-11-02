<?php
session_start();
require_once '../../koneksi.php';

try{
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Request method tidak sesuai');
    }
    
    if(!isset($_POST['username']) || empty($_POST['username'])) {
        throw new Exception('username tidak boleh kosong');
    }

    if(!isset($_POST['password']) || empty($_POST['password'])) {
        throw new Exception('password tidak boleh kosong');
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT username FROM admin WHERE username = ? AND password = ?");

    $stmt->bind_param('ss', $username, $password);

    if(!$stmt->execute()) {
        throw new Exception("Gagal mengambil data");        
    } else {
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        if(isset($row['username']) && !empty($row['username'])) {
            $_SESSION['LOGGED_IN'] = true;
            header('Location: ../../index.php');
        } else {
            echo "
                <script>
                alert('Login gagal');
                window.location.href = '../../views/login/login.php';
                </script>
            ";
        }

    }
}catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
