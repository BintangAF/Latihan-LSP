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
        if(!isset($_POST['kelas']) || empty($_POST['kelas'])) {
            throw new Exception("kelas tidak boleh kosong");        
        }

        if(!isset($_POST['id_guru']) || empty($_POST['id_guru'])) {
            throw new Exception("id guru tidak boleh kosong");        
        }

        if(!isset($_POST['jam_ke']) || empty($_POST['jam_ke'])) {
            throw new Exception("jam pelajaran tidak boleh kosong");        
        }

        $kelas = $_POST['kelas'];
        $id_guru = $_POST['id_guru'];
        $jam_ke = $_POST['jam_ke'];

        $sql = "INSERT INTO jadwal_kelas
                (kelas, id_guru, jam_ke)
                VALUES
                (?, ?, ?)
                ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $kelas, $id_guru, $jam_ke);

        if(!$stmt->execute()) {
            throw new Exception("Gagal mengirim data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Insert Data');
                    window.location.href = '../../views/jadwal/kelola_jadwal.php';
                </script>
            ";
        }

    }catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function updateData($conn) {
    try{

        if(!isset($_POST['id_guru']) || empty($_POST['id_guru'])) {
            throw new Exception("id_guru tidak boleh kosong");        
        }

        $id_guru = $_POST['id_guru']; 

        if(!isset($_POST['nama_guru']) || empty($_POST['nama_guru'])) {
            throw new Exception("nama guru tidak boleh kosong");        
        }

        if(!isset($_POST['mata_pelajaran']) || empty($_POST['mata_pelajaran'])) {
            throw new Exception("mata pelajaran tidak boleh kosong");        
        }

        $nama_guru = $_POST['nama_guru'];
        $mata_pelajaran = $_POST['mata_pelajaran'];        

        $sql = "UPDATE guru SET 
                nama_guru = ?, mata_pelajaran = ? 
                WHERE id_guru = ?                                
                ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $nama_guru, $mata_pelajaran, $id_guru);

        if(!$stmt->execute()) {
            throw new Exception("Gagal mengirim data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Update Data');
                    window.location.href = '../../views/guru/kelola_guru.php';
                </script>
            ";
        }

    }catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function deleteData($conn) {
    try{
        if(!isset($_GET['id_guru']) || empty($_GET['id_guru'])) {
            throw new Exception("id guru tidak boleh kosong");        
        }

        $id_guru = $_GET['id_guru'];

        $stmt = $conn->prepare("DELETE FROM guru WHERE id_guru = ?");

        $stmt->bind_param('i', $id_guru);

        if(!$stmt->execute()) {
            throw new Exception("Gagal Hapus Data");            
        } else {
            echo "
                <script>
                    alert('Berhasil Hapus Data');
                    window.location.href = '../../views/guru/kelola_guru.php';
                </script>
            ";
        }


    }catch(Exception $e) {
        echo "Error: ". $e->getMessage();
    }
}

// update & delete jadwal, update & delete di dashboard