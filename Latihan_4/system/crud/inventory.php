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

        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception("Nama Barang tidak boleh kosong");            
        }

        if(!isset($_POST['jenis_barang']) || empty($_POST['jenis_barang'])) {
            throw new Exception("Jenis Barang tidak boleh kosong");            
        }

        if(!isset($_POST['kuantitas']) || empty($_POST['kuantitas'])) {
            throw new Exception("kuantitas tidak boleh kosong");            
        }

        if(!isset($_POST['id_gudang']) || empty($_POST['id_gudang'])) {
            throw new Exception("ID Gudang tidak boleh kosong");            
        }

        $data_barang = explode(',', $_POST['nama_barang']);
        $nama_barang = $data_barang[0];
        $id_vendor = $data_barang[1];        
        $jenis_barang = $_POST['jenis_barang'];
        $kuantitas = $_POST['kuantitas'];
        $id_gudang = $_POST['id_gudang'];

        $sql = "INSERT INTO inventory
                (nama_barang, jenis_barang, kuantitas, id_vendor, id_gudang)
                VALUES
                (?, ?, ?, ?, ?)
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiii', $nama_barang, $jenis_barang, $kuantitas, $id_vendor, $id_gudang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Insert Data');
                    window.location.href = '../../views/inventory/kelola_inventory.php';
                </script>
            ";
        }

    }catch(Exception $e) {
        echo "Error :". $e->getMessage();
    }
}

function updateData($conn) {
    try{

        if(!isset($_POST['id_barang']) || empty($_POST['id_barang'])) {
            throw new Exception("ID Barang tidak ditemukan");            
        }

        $id_barang = $_POST['id_barang'];

        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception("Nama Barang tidak boleh kosong");            
        }

        if(!isset($_POST['jenis_barang']) || empty($_POST['jenis_barang'])) {
            throw new Exception("Jenis Barang tidak boleh kosong");            
        }

        if(!isset($_POST['kuantitas']) || empty($_POST['kuantitas'])) {
            throw new Exception("kuantitas tidak boleh kosong");            
        }

        if(!isset($_POST['id_gudang']) || empty($_POST['id_gudang'])) {
            throw new Exception("ID Gudang tidak boleh kosong");            
        }

        $data_barang = explode(',', $_POST['nama_barang']);
        $nama_barang = $data_barang[0];
        $id_vendor = $data_barang[1];        
        $jenis_barang = $_POST['jenis_barang'];
        $kuantitas = $_POST['kuantitas'];
        $id_gudang = $_POST['id_gudang'];

        $sql = "UPDATE inventory SET
                nama_barang = ?, jenis_barang = ?, kuantitas = ?, id_vendor = ?, id_gudang = ? 
                WHERE id_barang = ?                
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiiii', $nama_barang, $jenis_barang, $kuantitas, $id_vendor, $id_gudang, $id_barang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Update Data');
                    window.location.href = '../../views/inventory/kelola_inventory.php';
                </script>
            ";
        }

    }catch(Exception $e) {
        echo "Error :". $e->getMessage();
    }
}

function deleteData($conn) {
    try{

        if(!isset($_GET['id_barang']) || empty($_GET['id_barang'])) {
            throw new Exception("ID inventory tidak ditemukan");            
        }

        $id_barang = $_GET['id_barang'];        

        $sql = "DELETE FROM inventory WHERE id_barang = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_barang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal eksekusi kueri");            
        } else {
            echo "
                <script>
                    alert('Berhasil Hapus Data');
                    window.location.href = '../../views/inventory/kelola_inventory.php';
                </script>
            ";
        }

    }catch(Exception $e) {
        if(strpos($e->getMessage(), "a foreign key constraint fails") !== false) {
            echo "
                <script>
                    alert('Gagal Hapus Data, data ini terkait dengan data lain');
                    window.location.href = '../../views/inventory/kelola_inventory.php';
                </script>
            ";
        } else {
            echo "Error :". $e->getMessage();
        }
    }
}