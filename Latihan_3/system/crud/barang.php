<?php

require_once '../../koneksi.php';

if(isset($_POST['act']) && !empty($_POST['act'])) {
    $act = $_POST['act'];
} elseif(isset($_GET['act']) && !empty($_GET['act'])) {
    $act = $_GET['act'];
} else {
    die("Act tidak ditemukan");    
}

if($act == 'insert') {
    insertData($conn);
} elseif($act == 'update') {
    updateData($conn);
} elseif($act == 'delete') {
    deleteData($conn);
} else {
    die("Act tidak sesuai");
}

function insertData($conn) {
    try{

        if(!isset($_POST['id_barang_vendor']) || empty($_POST['id_barang_vendor'])) {
            throw new Exception("ID Barang Vendor kosong");            
        }

        if(!isset($_POST['id_gudang']) || empty($_POST['id_gudang'])) {
            throw new Exception("ID Gudang kosong");            
        }

        $id_barang_vendor = $_POST['id_barang_vendor'];
        $id_gudang = $_POST['id_gudang'];

        $sql = "INSERT INTO barang
                (id_barang_vendor, id_gudang)
                VALUES
                (?, ?)
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $id_barang_vendor, $id_gudang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Insert Data');
                    window.location.href = '../../views/barang/kelola_barang.php';
                </script>
            ";
        }
        
    }catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function updateData($conn) {
    try{

        if(!isset($_POST['id_barang']) || empty($_POST['id_barang'])) {
            throw new Exception("ID Barang kosong");            
        }

        $id_barang = $_POST['id_barang'];

        
        if(!isset($_POST['id_barang_vendor']) || empty($_POST['id_barang_vendor'])) {
            throw new Exception("ID Barang Vendor kosong");            
        }

        if(!isset($_POST['id_gudang']) || empty($_POST['id_gudang'])) {
            throw new Exception("ID Gudang kosong");            
        }

        $id_barang_vendor = $_POST['id_barang_vendor'];
        $id_gudang = $_POST['id_gudang'];

        $sql = "UPDATE barang SET
                id_barang_vendor = ?, id_gudang = ?
                WHERE id_barang = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iii', $id_barang_vendor, $id_gudang, $id_barang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Update Data');
                    window.location.href = '../../views/barang/kelola_barang.php';
                </script>
            ";
        }
        
    }catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function deleteData($conn) {
    try{

        if(!isset($_GET['id_barang']) || empty($_GET['id_barang'])) {
            throw new Exception("ID Barang kosong");            
        }

        $id_barang = $_GET['id_barang'];

        $sql = "DELETE FROM barang WHERE id_barang = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_barang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Hapus Data');
                    window.location.href = '../../views/barang/kelola_barang.php';
                </script>
            ";
        }
        
    }catch(Exception $e) {
        if(strpos($e->getMessage(), "a foreign key constraint fails")) {
            echo "
                <script>
                    alert('Error: Gagal Hapus Data, data ini terkait dengan data lain.');
                    window.location.href = '../../views/barang/kelola_barang.php';
                </script>
            ";
        } else {
            echo "Error: " . $e->getMessage();
        }        
    }
}