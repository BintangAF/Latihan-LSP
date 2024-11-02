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

        if(!isset($_POST['id_vendor']) || empty($_POST['id_vendor'])) {
            throw new Exception("ID Vendor kosong");            
        }

        $id_vendor = $_POST['id_vendor'];
        
        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception("Nama Barang kosong");            
        }

        if(!isset($_POST['harga']) || empty($_POST['harga'])) {
            throw new Exception("Harga kosong");            
        }

        if(!isset($_POST['stok']) || $_POST['stok'] < 0 ) {
            throw new Exception("Stok tidak ditemukan atau tidak boleh kurang dari 0");            
        }

        $nama_barang = $_POST['nama_barang'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];

        $sql = "INSERT INTO barang_vendor
                (nama_barang, harga, stok, id_vendor)
                VALUES
                (?, ?, ?, ?)
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('siii', $nama_barang, $harga, $stok, $id_vendor);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Insert Data');
                    window.location.href = '../../views/barang_vendor/kelola_barang_v.php?id_vendor=$id_vendor';
                </script>
            ";
        }
        
    }catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function updateData($conn) {
    try{

        if(!isset($_POST['id_vendor']) || empty($_POST['id_vendor'])) {
            throw new Exception("ID Vendor kosong");            
        }

        $id_vendor = $_POST['id_vendor'];

        if(!isset($_POST['id_barang_vendor']) || empty($_POST['id_barang_vendor'])) {
            throw new Exception("ID Barang Vendor kosong");            
        }

        $id_barang_vendor = $_POST['id_barang_vendor'];
        
        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception("Nama Barang kosong");            
        }

        if(!isset($_POST['harga']) || empty($_POST['harga'])) {
            throw new Exception("Harga kosong");            
        }

        if(!isset($_POST['stok']) || $_POST['stok'] < 0 ) {
            throw new Exception("Stok tidak ditemukan atau tidak boleh kurang dari 0");            
        }

        $nama_barang = $_POST['nama_barang'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];

        $sql = "UPDATE barang_vendor SET
                nama_barang = ?, harga = ?, stok = ?
                WHERE id_barang_vendor = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('siii', $nama_barang, $harga, $stok, $id_barang_vendor);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Update Data');
                    window.location.href = '../../views/barang_vendor/kelola_barang_v.php?id_vendor=$id_vendor';
                </script>
            ";
        }
        
    }catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function deleteData($conn) {
    try{

        if(!isset($_GET['id_vendor']) || empty($_GET['id_vendor'])) {
            throw new Exception("ID Vendor kosong");            
        }

        $id_vendor = $_GET['id_vendor'];        
        
        if(!isset($_GET['id_barang_vendor']) || empty($_GET['id_barang_vendor'])) {
            throw new Exception("ID Barang Vendor kosong");            
        }

        $id_barang_vendor = $_GET['id_barang_vendor'];

        $sql = "DELETE FROM barang_vendor WHERE id_barang_vendor = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_barang_vendor);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Hapus Data');
                    window.location.href = '../../views/barang_vendor/kelola_barang_v.php?id_vendor=$id_vendor';
                </script>
            ";
        }
        
    }catch(Exception $e) {
        if(strpos($e->getMessage(), "a foreign key constraint fails")) {
            echo "
                <script>
                    alert('Error: Gagal Hapus Data, data ini terkait dengan data lain.');
                    window.location.href = '../../views/barang_vendor/kelola_barang_v.php?id_vendor=$id_vendor';
                </script>
            ";
        } else {
            echo "Error: " . $e->getMessage();
        }        
    }
}