<?php
require_once '../../koneksi.php';

if(!isset($_GET['id_guru']) || empty($_GET['id_guru'])) {
    echo "id guru tidak ditemukan";
    exit;
}

$id_guru = $_GET['id_guru'];

$stmt = $conn->prepare("SELECT * FROM guru WHERE id_guru = ?");
$stmt->bind_param('i', $id_guru);

if(!$stmt->execute()) {
    echo "gagal mengambil data";
    exit;
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>

<?php require_once '../layout/header.php';?>

<section id="konten">
    <div class="container">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h4>Tambah Guru</h4>
                <a class="btn btn-primary" href="kelola_guru.php">Daftar Guru</a>
            </div>
            <form action="../../system/crud/guru.php" method="post">
            <div class="card-body">
                <input type="hidden" name="act" value="update">
                <input type="hidden" name="id_guru" value="<?= $id_guru ?>">
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="nama_guru" id="namaGuru" placeholder="Masukkan Nama Guru" value="<?= $row['nama_guru']?>" required>
                            <label for="namaGuru">Nama Guru</label>
                        </div>                        
                    </div>
                    <div class="col-6">                        
                        <div class="form-floating">
                            <input type="text" class="form-control" name="mata_pelajaran" id="mapel" placeholder="Masukkan Mata Pelajaran" value="<?= $row['mata_pelajaran']?>" required>
                            <label for="mapel">Mata Pelajaran</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Kirim</button>
            </div>
            </form>
        </div>
    </div>
</section>


<?php require_once '../layout/footer.php';?>


