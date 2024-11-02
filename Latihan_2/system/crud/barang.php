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
        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception("Nama Barang kosong");    
        }

        if(!isset($_POST['jenis_barang']) || empty($_POST['jenis_barang'])) {
            throw new Exception("Jenis Barang kosong");    
        }

        if(!isset($_POST['stok']) || $_POST < 0) {
            throw new Exception("Stok kosong atau kurang dari 0");    
        }

        if(!isset($_POST['id_gudang']) || empty($_POST['id_gudang'])) {
            throw new Exception("ID Gudang kosong");    
        }        

        if(!isset($_POST['barcode']) || empty($_POST['barcode'])) {
            throw new Exception("Barcode kosong");    
        }        

        if(!isset($_POST['nama_vendor']) || empty($_POST['nama_vendor'])) {
            throw new Exception("nama_vendor kosong");    
        }        

        $nama_barang = $_POST['nama_barang'];
        $jenis_barang = $_POST['jenis_barang'];
        $stok = $_POST['stok'];
        $id_gudang = $_POST['id_gudang'];                
        $barcode = $_POST['barcode'];                
        $nama_vendor = $_POST['nama_vendor'];                

        $sql = "INSERT INTO barang 
                (nama_barang, jenis_barang, stok, id_gudang, barcode, nama_vendor)
                VALUES
                (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiiis', $nama_barang, $jenis_barang, $stok, $id_gudang, $barcode, $nama_vendor);
        

        if(!$stmt->execute()) {
            throw new Exception("gagal mengambil data");            
        }else {            
            echo "
                <script>
                    alert('Berhasil memasukkan data');
                    window.location.href = '../../views/barang/kelola_barang.php';
                </script>            
            ";
        }

        

    }catch(Exception $e) {
        echo "Error: " .$e->getMessage();
    }
}
function updateData($conn) {
    try{        

        if(!isset($_POST['id_barang']) || empty($_POST['id_barang'])) {
            throw new Exception("ID Barang kosong");    
        }

        $id_barang = $_POST['id_barang'];

        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception("Nama Barang kosong");    
        }

        if(!isset($_POST['jenis_barang']) || empty($_POST['jenis_barang'])) {
            throw new Exception("Jenis Barang kosong");    
        }

        if(!isset($_POST['stok']) || $_POST < 0) {
            throw new Exception("Stok kosong atau kurang dari 0");    
        }

        if(!isset($_POST['id_gudang']) || empty($_POST['id_gudang'])) {
            throw new Exception("ID Gudang kosong");    
        }        

        if(!isset($_POST['barcode']) || empty($_POST['barcode'])) {
            throw new Exception("Barcode kosong");    
        }        

        if(!isset($_POST['nama_vendor']) || empty($_POST['nama_vendor'])) {
            throw new Exception("nama_vendor kosong");    
        }        

        $nama_barang = $_POST['nama_barang'];
        $jenis_barang = $_POST['jenis_barang'];
        $stok = $_POST['stok'];
        $id_gudang = $_POST['id_gudang'];                
        $barcode = $_POST['barcode'];                
        $nama_vendor = $_POST['nama_vendor'];                
             

        $sql = "UPDATE barang SET 
                nama_barang = ?, jenis_barang = ?, stok = ?, id_gudang = ?, barcode = ?, nama_vendor = ?
                WHERE
                id_barang = ? ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiiisi', $nama_barang, $jenis_barang, $stok, $id_gudang, $barcode, $nama_vendor, $id_barang); 
        

        if(!$stmt->execute()) {
            throw new Exception("gagal mengambil data");            
        }else {            
            echo "
                <script>
                    alert('Berhasil memperbarui data');
                    window.location.href = '../../views/barang/kelola_barang.php';
                </script>            
            ";
        }        

    }catch(Exception $e) {
        echo "Error: " .$e->getMessage();
    }
}

function deleteData($conn) {
    try {
        if(!isset($_GET['id_barang']) || empty($_GET['id_barang'])) {
            throw new Exception("ID barang tidak ditemukan");            
        }

        $id_barang = $_GET['id_barang'];

        $stmt = $conn->prepare("DELETE FROM barang WHERE id_barang = ?");
        $stmt->bind_param('i', $id_barang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal mengambil data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Hapus data');
                    window.location.href = '../../views/barang/kelola_barang.php';
                </script>
            ";
        }
        
    } catch (Exception $e) {                                      
        echo "Error:". $e->getMessage();        
    }
}
