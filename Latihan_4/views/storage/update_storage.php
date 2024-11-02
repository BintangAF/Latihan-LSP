<?php require_once '../layout/header.php'; ?>

<?php 

if(!isset($_GET['id_gudang']) || empty($_GET['id_gudang'])) {
    die("ID Gudang tidak ditemukan");
}

$id_gudang = $_GET['id_gudang'];

$stmt = $conn->prepare("SELECT * FROM storage_unit WHERE id_gudang = ?");
$stmt->bind_param('i', $id_gudang);

if(!$stmt->execute()){
    die("Gagal mengambil data vendor");
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>

<section class="mt-3" id="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Update Data Gudang</h3>                        
                        <a href="kelola_storage.php" class="btn btn-primary">Daftar Gudang</a>                        
                    </div>
                    <form action="../../system/crud/storage.php" method="post">
                        <input type="hidden" name="act" value="update">
                        <input type="hidden" name="id_gudang" value="<?= $id_gudang ?>">
                        <div class="card-body">
                            <!-- <div class="row"> -->
                                <div class="mb-3">
                                    <label for="nama_gudang">Nama Gudang</label>
                                    <input type="text" name="nama_gudang" id="nama_gudang" class="form-control" placeholder="Masukkan Nama Gudang" value="<?= $row['nama_gudang'] ?>" required>                                                                        
                                </div>
                                <div class="mb-3">
                                    <label for="lokasi_gudang">Lokasi Gudang</label>
                                    <input type="text" name="lokasi_gudang" id="lokasi_gudang" class="form-control" placeholder="Masukkan Lokasi Gudang" value="<?= $row['lokasi_gudang'] ?>" required>
                                </div>                                
                            <!-- </div> -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Kirim</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../layout/footer.php'; ?>