<?php require_once '../layout/header.php'; ?>
<?php 

if(!isset($_GET['id_vendor']) || empty($_GET['id_vendor'])) {
    die("ID Vendor Tidak ditemukan atau kosong");
}

$id_vendor = $_GET['id_vendor'];

$stmt = $conn->prepare("SELECT * FROM vendor WHERE id_vendor  = ?");
$stmt->bind_param('i', $id_vendor);

if(!$stmt->execute()) {
    die("Gagal Mengambil Data");
}

$result = $stmt->get_result();
$stmt->close();
$row = $result->fetch_assoc();

?>

<section class="mt-3" id="content">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Update Data Vendor</h3>
                        <a href="kelola_vendor.php" class="btn btn-primary">Daftar Vendor</a>
                    </div>
                    <form action="../../system/crud/vendor.php" method="post">
                        <input type="hidden" name="act" value="update">
                        <input type="hidden" name="id_vendor" value="<?=$id_vendor ?>">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nama_vendor">Nama Vendor</label>
                                <input type="text" class="form-control" name="nama_vendor" id="nama_vendor" placeholder="Masukkan Nama Vendor" value="<?= $row['nama_vendor'] ?>" required>                                
                            </div>

                            <div class="mb-3">
                                <label for="kontak">Kontak</label>
                                <input type="number" class="form-control" name="kontak" id="kontak" placeholder="Masukkan Nomor Kontak" value="<?= $row['kontak'] ?>" required>
                            </div>
                        </div>                
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Kirim</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                        </div>  
                    </form>
                </div>
            </d>
        </div>
    </div>
</section>

<?php require_once '../layout/footer.php'; ?>