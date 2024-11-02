<?php 

require_once '../../koneksi.php';

if(isset($_POST['act']) && !empty($_POST['act'])) {
    $act = $_POST['act'];
} elseif(isset($_GET['act']) && !empty($_GET['act'])) {
    $act = $_GET['act'];
}

if($act == 'insert') {
    insertData($conn);    
} elseif($act == 'update') {
    updateData($conn);    
} elseif($act == 'delete') {
    deleteData($conn);    
}

function insertData($conn) {
    try{
        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception('nama barang tidak boleh kosong');
        }

        if(!isset($_POST['jenis_barang']) || empty($_POST['jenis_barang'])) {
            throw new Exception('jenis barang tidak boleh kosong');
        }

        if(!isset($_POST['barcode']) || empty($_POST['barcode'])) {
            throw new Exception('barcode tidak boleh kosong');
        }

        if(!isset($_POST['stok']) || $_POST['stok'] < 0) {
            throw new Exception('barang tidak boleh kosong atau kurang dari 0');
        }

        if(!isset($_POST['lokasi_gudang']) || empty($_POST['lokasi_gudang'])) {
            throw new Exception('lokasi gudang tidak boleh kosong');
        }        

        $nama_barang = $_POST['nama_barang'];
        $jenis_barang = $_POST['jenis_barang'];
        $barcode = $_POST['barcode'];
        $stok = $_POST['stok'];
        $lokasi_gudang = $_POST['lokasi_gudang'];        

        $sql = "INSERT INTO barang
                (nama_barang, jenis_barang, lokasi_gudang, barcode, stok)
                VALUES
                (?, ?, ?, ?, ?)
                "; 
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('sssii', $nama_barang, $jenis_barang, $lokasi_gudang, $barcode, $stok);

        if(!$stmt->execute()) {
            throw new Exception('Gagal mengirim data');
        } else {
            echo "
                <script>
                    alert('Berhasil Insert Data');
                    window.location.href = '../../views/barang/kelola_barang.php';
                </script>
            
            ";
        }

    }catch(Exception $e) {
        if(strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo "
                <script>
                    alert('Nama Gudang sudah ada');
                    window.location.href = '../../views/barang/tambah_barang.php';
                </script>
            ";
        } else {
            echo "Error: " .$e->getMessage();
        }
    }
}

function updateData($conn) {
    try{

        if(!isset($_POST['id_barang'])|| empty($_POST['id_barang'])) {
            throw new Exception("id barang tidak boleh kosong");            
        }

        $id_barang = $_POST['id_barang'];

        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception('nama barang tidak boleh kosong');
        }

        if(!isset($_POST['jenis_barang']) || empty($_POST['jenis_barang'])) {
            throw new Exception('jenis barang tidak boleh kosong');
        }

        if(!isset($_POST['barcode']) || empty($_POST['barcode'])) {
            throw new Exception('barcode tidak boleh kosong');
        }

        if(!isset($_POST['stok']) || $_POST['stok'] < 0) {
            throw new Exception('nama barang tidak boleh kosong atau kurang dari 0');
        }

        if(!isset($_POST['lokasi_gudang']) || empty($_POST['lokasi_gudang'])) {
            throw new Exception('lokasi gudang tidak boleh kosong');
        }        

        $nama_barang = $_POST['nama_barang'];
        $jenis_barang = $_POST['jenis_barang'];
        $barcode = $_POST['barcode'];
        $stok = $_POST['stok'];
        $lokasi_gudang = $_POST['lokasi_gudang'];        

        $sql = "UPDATE barang SET
                nama_barang = ?, lokasi_gudang = ?, jenis_barang = ?, stok = ?, barcode = ?
                WHERE id_barang = ?
        ";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param('sssiii', $nama_barang, $lokasi_gudang, $jenis_barang, $stok, $barcode, $id_barang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal mengupdate data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Update Data');
                    window.location.href = '../../views/barang/kelola_barang.php';
                </script>
            
            ";
        }

    }catch(Exception $e) {        
        if(strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo "
                <script>
                    alert('ID Barang sudah ada');
                    window.location.href = '../../views/barang/update_barang.php?id_barang=$id_barang';
                </script>
            ";
        } else {
            echo "Error: " .$e->getMessage();
        }
    }
}

function deleteData($conn) {
    try{
        if(!isset($_GET['id_barang']) || empty($_GET['id_barang'])) {
            throw new Exception("ID barang tidak ditemukan");        
        }

        $id_barang = $_GET['id_barang'];

        $stmt = $conn->prepare("DELETE FROM barang WHERE id_barang =?");

        $stmt->bind_param('i', $id_barang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal menghapus data");            
        } else {
            echo "
            <script>
                alert('Berhasil Hapus Data');
                window.location.href = '../../views/barang/kelola_barang.php';
            </script>
        ";
        }

    }catch(Exception $e) {
        echo "Error: " .$e->getMessage();        
    }
}

