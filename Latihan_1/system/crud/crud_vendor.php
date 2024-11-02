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
        if(!isset($_POST['nama_vendor']) || empty($_POST['nama_vendor'])) {
            throw new Exception('nama vendor tidak boleh kosong');
        }

        if(!isset($_POST['nama_barang']) || empty($_POST['nama_barang'])) {
            throw new Exception('nama barang tidak boleh kosong');
        }

        if(!isset($_POST['kontak']) || empty($_POST['kontak'])) {
            throw new Exception('kontak tidak boleh kosong');
        }

        if(!isset($_POST['nomor_invoice']) || empty($_POST['nomor_invoice'])) {
            throw new Exception('nomor invoice tidak boleh kosong');
        }

        $nama_vendor = $_POST['nama_vendor'];
        $nama_barang = $_POST['nama_barang'];
        $kontak = $_POST['kontak'];
        $nomor_invoice = $_POST['nomor_invoice'];

        $sql = "INSERT INTO vendor
                (nama_barang, nama_vendor, nomor_invoice, kontak)
                VALUES
                (?, ?, ?, ?)
                "; 
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ssii', $nama_barang, $nama_vendor, $nomor_invoice, $kontak);

        if(!$stmt->execute()) {
            throw new Exception('Gagal mengirim data');
        } else {
            echo "
                <script>
                    alert('Berhasil Insert Data');
                    window.location.href = '../../views/vendor/kelola_vendor.php';
                </script>
            
            ";
        }

    }catch(Exception $e) {
        if(strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo "
                <script>
                    alert('Nama Barang sudah ada');
                    window.location.href = '../../views/vendor/tambah_vendor.php';
                </script>
            ";
        } else {
            echo "Error: " .$e->getMessage();
        }
    }
}

function updateData($conn) {
    try{

        if(!isset($_POST['nomor_invoice'])|| empty($_POST['nomor_invoice'])) {
            throw new Exception("nomor invoice tidak boleh kosong");            
        }

        $nomor_invoice = $_POST['nomor_invoice'];

        if(!isset($_POST['nama_vendor'])|| empty($_POST['nama_vendor'])) {
            throw new Exception("nama vendor tidak boleh kosong");            
        }

        if(!isset($_POST['nama_barang'])|| empty($_POST['nama_barang'])) {
            throw new Exception("nama barang tidak boleh kosong");            
        }

        if(!isset($_POST['kontak'])|| empty($_POST['kontak'])) {
            throw new Exception("kontak tidak boleh kosong");            
        }

        $nama_vendor = $_POST['nama_vendor'];
        $nama_barang = $_POST['nama_barang'];
        $kontak = $_POST['kontak'];

        $sql = "UPDATE vendor SET
                nama_barang = ?, nama_vendor = ?, kontak = ?                                
                WHERE nomor_invoice = ?
        ";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ssii', $nama_barang, $nama_vendor, $kontak, $nomor_invoice);

        if(!$stmt->execute()) {
            throw new Exception("Gagal mengupdate data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Update Data');
                    window.location.href = '../../views/vendor/kelola_vendor.php';
                </script>
            
            ";
        }

    }catch(Exception $e) {        
        if(strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo "
                <script>
                    alert('Nama Barang sudah ada');
                    window.location.href = '../../views/vendor/update_vendor.php?nomor_invoice=$nomor_invoice';
                </script>
            ";
        } else {
            echo "Error: " .$e->getMessage();
        }
    }
}

function deleteData($conn) {
    try{
        if(!isset($_GET['nomor_invoice']) || empty($_GET['nomor_invoice'])) {
            throw new Exception("Nomor Invoice tidak ditemukan");        
        }

        $nomor_invoice = $_GET['nomor_invoice'];

        $stmt = $conn->prepare("DELETE FROM vendor WHERE nomor_invoice = ?");

        $stmt->bind_param('i', $nomor_invoice);

        if(!$stmt->execute()) {
            throw new Exception("Gagal menghapus data");            
        } else {
            echo "
            <script>
                alert('Berhasil Hapus Data');
                window.location.href = '../../views/vendor/kelola_vendor.php';
            </script>
        ";
        }

    }catch(Exception $e) {
        if(strpos($e->getMessage(), ' a foreign key constraint fails') !== false) {
            echo "
                <script>
                    alert('Gagal Hapus Data, data ini terkait dengan data lain.');
                    window.location.href = '../../views/vendor/kelola_vendor.php';
                </script>
            ";                    
        }else {
            echo "Error: " .$e->getMessage();        
        }
    }
}


