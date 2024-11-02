<?php
require_once '../../koneksi.php';

if(isset($_POST['act']) && !empty($_POST['act'])) {
    $act = $_POST['act'];
} elseif(isset($_GET['act']) && !empty($_GET['act'])) {
    $act = $_GET['act'];
} else {
    echo "Act kosong";
    exit;
}


if($act == 'insert') {
    insertData($conn);
} elseif($act == 'update') {
    updateData($conn);
} elseif($act == 'delete') {
    deleteData($conn);
} else {
    echo "Act tidak sesuai";
    exit;
}

function insertData($conn) {
    try{        
        if(!isset($_POST['nama_gudang']) || empty($_POST['nama_gudang'])) {
            throw new Exception("Nama Gudang kosong");    
        }

        if(!isset($_POST['lokasi_gudang']) || empty($_POST['lokasi_gudang'])) {
            throw new Exception("Lokasi Gudang kosong");    
        }
        
        $nama_gudang = $_POST['nama_gudang'];
        $lokasi_gudang = $_POST['lokasi_gudang'];        

        $sql = "INSERT INTO gudang 
                (nama_gudang, lokasi_gudang)
                VALUES
                (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $nama_gudang, $lokasi_gudang);
        

        if(!$stmt->execute()) {
            throw new Exception("gagal mengirim data");            
        }else {            
            echo "
                <script>
                    alert('Berhasil memasukkan data');
                    window.location.href = '../../views/gudang/kelola_gudang.php';
                </script>            
            ";
        }

        

    }catch(Exception $e) {
        echo "Error: " .$e->getMessage();
    }
}
function updateData($conn) {
    try{        
        if(!isset($_POST['id_gudang']) || empty($_POST['id_gudang'])) {
            throw new Exception("ID Gudang kosong");    
        }

        $id_gudang = $_POST['id_gudang'];

        if(!isset($_POST['nama_gudang']) || empty($_POST['nama_gudang'])) {
            throw new Exception("Nama Gudang kosong");    
        }

        if(!isset($_POST['lokasi_gudang']) || empty($_POST['lokasi_gudang'])) {
            throw new Exception("Lokasi Gudang kosong");    
        }
        
        $nama_gudang = $_POST['nama_gudang'];
        $lokasi_gudang = $_POST['lokasi_gudang'];               

        $sql = "UPDATE gudang SET 
                nama_gudang = ?, lokasi_gudang = ?
                WHERE
                id_gudang = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $nama_gudang, $lokasi_gudang, $id_gudang);
        

        if(!$stmt->execute()) {
            throw new Exception("gagal mengambil data");            
        }else {            
            echo "
                <script>
                    alert('Berhasil memperbarui data');
                    window.location.href = '../../views/gudang/kelola_gudang.php';
                </script>            
            ";
        }        

    }catch(Exception $e) {
        echo "Error: " .$e->getMessage();
    }
}

function deleteData($conn) {
    try {
        if(!isset($_GET['id_gudang']) || empty($_GET['id_gudang'])) {
            throw new Exception("ID Gudang tidak ditemukan");            
        }

        $id_gudang = $_GET['id_gudang'];

        $stmt = $conn->prepare("DELETE FROM gudang WHERE id_gudang = ?");
        $stmt->bind_param('i', $id_gudang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal mengambil data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Hapus data');
                    window.location.href = '../../views/gudang/kelola_gudang.php';
                </script>
            ";
        }
        
    } catch (Exception $e) {
        if(strpos($e->getMessage(), "a foreign key constraint fails") !== false) {
            echo "
                <script>
                    alert('Gagal hapus data, karena data ini terkait dengan data lain');
                    window.location.href = '../../views/gudang/kelola_gudang.php';
                </script>
            ";
        } else {                                
            echo "Error:". $e->getMessage();
        }
    }
}
