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
        if(!isset($_POST['nama_vendor']) || empty($_POST['nama_vendor'])) {
            throw new Exception("Nama Vendor kosong");    
        }

        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception("Nama Barang kosong");    
        }

        if(!isset($_POST['kontak']) || empty($_POST['kontak'])) {
            throw new Exception("Kontak kosong");    
        }

        if(!isset($_POST['nomor_invoice']) || empty($_POST['nomor_invoice'])) {
            throw new Exception("Nomor Invoice kosong");    
        }        

        $nama_vendor = $_POST['nama_vendor'];
        $nama_barang = $_POST['nama_barang'];
        $kontak = $_POST['kontak'];
        $nomor_invoice = $_POST['nomor_invoice'];                

        $sql = "INSERT INTO vendor 
                (nomor_invoice, nama_vendor, nama_barang, kontak)
                VALUES
                (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issi', $nomor_invoice, $nama_vendor, $nama_barang, $kontak);
        

        if(!$stmt->execute()) {
            throw new Exception("gagal mengambil data");            
        }else {            
            echo "
                <script>
                    alert('Berhasil memasukkan data');
                    window.location.href = '../../views/vendor/kelola_vendor.php';
                </script>            
            ";
        }

        

    }catch(Exception $e) {
        echo "Error: " .$e->getMessage();
    }
}
function updateData($conn) {
    try{        
        if(!isset($_POST['nama_vendor']) || empty($_POST['nama_vendor'])) {
            throw new Exception("Nama Vendor kosong");    
        }

        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception("Nama Barang kosong");    
        }

        if(!isset($_POST['kontak']) || empty($_POST['kontak'])) {
            throw new Exception("Kontak kosong");    
        }

        if(!isset($_POST['nomor_invoice']) || empty($_POST['nomor_invoice'])) {
            throw new Exception("Nomor Invoice kosong");    
        }        

        $nama_vendor = $_POST['nama_vendor'];
        $nama_barang = $_POST['nama_barang'];
        $kontak = $_POST['kontak'];
        $nomor_invoice = $_POST['nomor_invoice'];                

        $sql = "UPDATE vendor SET 
                nama_vendor = ?, nama_barang = ?, kontak = ?
                WHERE
                nomor_invoice = ? ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssii', $nama_vendor, $nama_barang, $kontak, $nomor_invoice);
        

        if(!$stmt->execute()) {
            throw new Exception("gagal mengambil data");            
        }else {            
            echo "
                <script>
                    alert('Berhasil memperbarui data');
                    window.location.href = '../../views/vendor/kelola_vendor.php';
                </script>            
            ";
        }        

    }catch(Exception $e) {
        echo "Error: " .$e->getMessage();
    }
}

function deleteData($conn) {
    try {
        if(!isset($_GET['nomor_invoice']) || empty($_GET['nomor_invoice'])) {
            throw new Exception("nomor invoice tidak ditemukan");            
        }

        $nomor_invoice = $_GET['nomor_invoice'];

        $stmt = $conn->prepare("DELETE FROM vendor WHERE nomor_invoice = ?");
        $stmt->bind_param('i', $nomor_invoice);

        if(!$stmt->execute()) {
            throw new Exception("Gagal mengambil data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Hapus data');
                    window.location.href = '../../views/vendor/kelola_vendor.php';
                </script>
            ";
        }
        
    } catch (Exception $e) {
        if(strpos($e->getMessage(), "a foreign key constraint fails") !== false) {
            echo "Gagal menghapus data. Data ini terkait dengan data lain";
        } else {                                
            echo "Error:". $e->getMessage();
        }
    }
}
