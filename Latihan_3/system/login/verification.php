<?php
session_start();

require_once '../../koneksi.php';

try{
    if(!isset($_POST['username']) || empty($_POST['username'])) {
        throw new Exception("Username kosong");        
    }

    if(!isset($_POST['password']) || empty($_POST['password'])) {
        throw new Exception("Password kosong");        
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('ss', $username, $password);

    if(!$stmt->execute()) {
        throw new Exception("Gagal eksekusi kueri");
    } else {
        $result = $stmt->get_result(); 

        if($result->num_rows > 0) {
            $_SESSION['LOGGED_IN'] = true;                        
            header('Location: ../../views/barang/kelola_barang.php');
        } else {
            echo "
                <script>
                    alert('Username atau Password salah');
                    window.location.href = '../../views/login/login.php';
                </script>            
            ";
        }
    }

}catch(Exception $e) {
    echo "Error: ". $e->getMessage();
}