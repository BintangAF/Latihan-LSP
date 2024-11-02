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

        if(!isset($_POST['nama_vendor']) || empty($_POST['nama_vendor'])) {
            throw new Exception("Nama Vendor kosong");            
        }

        if(!isset($_POST['kontak']) || empty($_POST['kontak'])) {
            throw new Exception("Kontak kosong");            
        }

        $nama_vendor = $_POST['nama_vendor'];
        $kontak = $_POST['kontak'];

        $sql = "INSERT INTO vendor
                (nama_vendor, kontak)
                VALUES
                (?, ?)
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $nama_vendor, $kontak);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Insert Data');
                    window.location.href = '../../views/vendor/kelola_vendor.php';
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

        
        if(!isset($_POST['nama_vendor']) || empty($_POST['nama_vendor'])) {
            throw new Exception("Nama Vendor kosong");            
        }

        if(!isset($_POST['kontak']) || empty($_POST['kontak'])) {
            throw new Exception("Kontak kosong");            
        }

        $nama_vendor = $_POST['nama_vendor'];
        $kontak = $_POST['kontak'];

        $sql = "UPDATE vendor SET
                nama_vendor = ?, kontak = ?
                WHERE id_vendor =?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $nama_vendor, $kontak, $id_vendor);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Update Data');
                    window.location.href = '../../views/vendor/kelola_vendor.php';
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

        $sql = "DELETE FROM vendor WHERE id_vendor = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_vendor);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Hapus Data');
                    window.location.href = '../../views/vendor/kelola_vendor.php';
                </script>
            ";
        }
        
    }catch(Exception $e) {
        if(strpos($e->getMessage(), "a foreign key constraint fails")) {
            echo "
                <script>
                    alert('Error: Gagal Hapus Data, data ini terkait dengan data lain.');
                    window.location.href = '../../views/vendor/kelola_vendor.php';
                </script>
            ";
        } else {
            echo "Error: " . $e->getMessage();
        }        
    }
}