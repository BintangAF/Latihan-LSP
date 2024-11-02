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
        if(!isset($_POST['nama_gudang']) || empty($_POST['nama_gudang'])) {
            throw new Exception('nama gudang tidak boleh kosong');
        }

        if(!isset($_POST['lokasi_gudang']) || empty($_POST['lokasi_gudang'])) {
            throw new Exception('lokasi gudang tidak boleh kosong');
        }        

        $nama_gudang = $_POST['nama_gudang'];
        $lokasi_gudang = $_POST['lokasi_gudang'];        

        $sql = "INSERT INTO gudang
                (lokasi_gudang, nama_gudang)
                VALUES
                (?, ?)
                "; 
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ss', $lokasi_gudang, $nama_gudang);

        if(!$stmt->execute()) {
            throw new Exception('Gagal mengirim data');
        } else {
            echo "
                <script>
                    alert('Berhasil Insert Data');
                    window.location.href = '../../views/gudang/kelola_gudang.php';
                </script>
            
            ";
        }

    }catch(Exception $e) {
        if(strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo "
                <script>
                    alert('Lokasi Gudang sudah ada');
                    window.location.href = '../../views/gudang/tambah_gudang.php';
                </script>
            ";
        } else {
            echo "Error: " .$e->getMessage();
        }
    }
}

function updateData($conn) {
    try{

        if(!isset($_POST['lokasi_gudang_lama'])|| empty($_POST['lokasi_gudang_lama'])) {
            throw new Exception("lokasi gudang lama tidak boleh kosong");            
        }

        $lokasi_gudang_lama = $_POST['lokasi_gudang_lama'];

        if(!isset($_POST['lokasi_gudang_baru'])|| empty($_POST['lokasi_gudang_baru'])) {
            throw new Exception("lokasi_gudang_baru tidak boleh kosong");            
        }

        if(!isset($_POST['nama_gudang'])|| empty($_POST['nama_gudang'])) {
            throw new Exception("nama gudang tidak boleh kosong");            
        }        

        $lokasi_gudang_baru = $_POST['lokasi_gudang_baru'];
        $nama_gudang = $_POST['nama_gudang'];        

        $sql = "UPDATE gudang SET
                lokasi_gudang = ?, nama_gudang = ?
                WHERE lokasi_gudang = ?
        ";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param('sss', $lokasi_gudang_baru, $nama_gudang, $lokasi_gudang_lama);

        if(!$stmt->execute()) {
            throw new Exception("Gagal mengupdate data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Update Data');
                    window.location.href = '../../views/gudang/kelola_gudang.php';
                </script>
            
            ";
        }

    }catch(Exception $e) {        
        if(strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo "
                <script>
                    alert('Lokasi Gudang sudah ada');
                    window.location.href = '../../views/gudang/update_gudang.php?lokasi_gudang_lama=$lokasi_gudang_lama';
                </script>
            ";
        } else {
            echo "Error: " .$e->getMessage();
        }
    }
}

function deleteData($conn) {
    try{
        if(!isset($_GET['lokasi_gudang']) || empty($_GET['lokasi_gudang'])) {
            throw new Exception("Lokasi gudang tidak ditemukan");        
        }

        $lokasi_gudang = $_GET['lokasi_gudang'];

        $stmt = $conn->prepare("DELETE FROM gudang WHERE lokasi_gudang =?");

        $stmt->bind_param('i', $lokasi_gudang);

        if(!$stmt->execute()) {
            throw new Exception("Gagal menghapus data");            
        } else {
            echo "
            <script>
                alert('Berhasil Hapus Data');
                window.location.href = '../../views/gudang/kelola_gudang.php';
            </script>
        ";
        }

    }catch(Exception $e) {
        if(strpos($e->getMessage(), ' a foreign key constraint fails') !== false) {
            echo "
                <script>
                    alert('Gagal Hapus Data, data ini terkait dengan data lain.');
                    window.location.href = '../../views/gudang/kelola_gudang.php';
                </script>
            ";                    
        }else {
            echo "Error: " .$e->getMessage();        
        }
    }
}


