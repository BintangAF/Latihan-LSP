<?php
require_once '../../koneksi.php';

if(isset($_POST['act']) && !empty($_POST['act'])) {    
    $act = $_POST['act'];
} elseif(isset($_GET['act']) && !empty($_GET['act'])) {
    $act = $_GET['act'];
} else {
    echo "act tidak ditemukan";
    exit;
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
        if(!isset($_POST['jenjang']) || empty($_POST['jenjang'])) {
            throw new Exception("jenjang tidak boleh kosong");        
        }

        if(!isset($_POST['konsentrasi_keahlian']) || empty($_POST['konsentrasi_keahlian'])) {
            throw new Exception("konsentrasi keahlian tidak boleh kosong");        
        }

        $jenjang = $_POST['jenjang'];
        $konsentrasi_keahlian = $_POST['konsentrasi_keahlian'];
        $kelas = $jenjang ." ". $konsentrasi_keahlian;

        $sql = "INSERT INTO kelas 
                (jenjang, konsentrasi_keahlian, kelas)
                VALUES
                (?, ?, ?)
                ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $jenjang, $konsentrasi_keahlian, $kelas);

        if(!$stmt->execute()) {
            throw new Exception("Gagal mengirim data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Insert Data');
                    window.location.href = '../../views/kelas/kelola_kelas.php';
                </script>
            ";
        }

    }catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function updateData($conn) {
    try{

        if(!isset($_POST['kelas_lama']) || empty($_POST['kelas_lama'])) {
            throw new Exception("kelas lama tidak boleh kosong");        
        }

        $kelas_lama = $_POST['kelas_lama']; 

        if(!isset($_POST['jenjang']) || empty($_POST['jenjang'])) {
            throw new Exception("jenjang tidak boleh kosong");        
        }

        if(!isset($_POST['konsentrasi_keahlian']) || empty($_POST['konsentrasi_keahlian'])) {
            throw new Exception("konsentrasi keahlian tidak boleh kosong");        
        }

        $jenjang = $_POST['jenjang'];
        $konsentrasi_keahlian = $_POST['konsentrasi_keahlian'];
        $kelas_baru = $jenjang ." ". $konsentrasi_keahlian;

        $sql = "UPDATE kelas SET 
                jenjang = ?, konsentrasi_keahlian = ?, kelas = ? 
                WHERE kelas = ?                                
                ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isss', $jenjang, $konsentrasi_keahlian, $kelas_baru, $kelas_lama);

        if(!$stmt->execute()) {
            throw new Exception("Gagal mengirim data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Update Data');
                    window.location.href = '../../views/kelas/kelola_kelas.php';
                </script>
            ";
        }

    }catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function deleteData($conn) {
    try{
        if(!isset($_GET['kelas']) || empty($_GET['kelas'])) {
            throw new Exception("kelas tidak boleh kosong");        
        }

        $kelas = $_GET['kelas'];

        $stmt = $conn->prepare("DELETE FROM kelas WHERE kelas = ?");

        $stmt->bind_param('s', $kelas);

        if(!$stmt->execute()) {
            throw new Exception("Gagal Hapus Data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Hapus Data');
                    window.location.href = '../../views/kelas/kelola_kelas.php';
                </script>
            ";
        }


    }catch(Exception $e) {
        echo "Error: ". $e->getMessage();
    }
}