<?php require_once '../layout/header.php'; ?>

<?php 

if(!isset($_GET['id_vendor']) || empty($_GET['id_vendor'])) {
    die("ID Vendor tidak ditemukab");
}

$id_vendor = $_GET['id_vendor'];

$stmt = $conn->prepare("SELECT * FROM vendor WHERE id_vendor = ?");
$stmt->bind_param('i', $id_vendor);

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
                        <h3>Update Data Vendor</h3>                        
                        <a href="kelola_vendor.php" class="btn btn-primary">Daftar Vendor</a>                        
                    </div>
                    <form action="../../system/crud/vendor.php" method="post">
                        <input type="hidden" name="act" value="update">
                        <input type="hidden" name="id_vendor" value="<?= $id_vendor ?>">
                        <div class="card-body">
                            <!-- <div class="row"> -->
                                <div class="mb-3">
                                    <label for="nama_vendor">Nama Vendor</label>
                                    <input type="text" name="nama_vendor" id="nama_vendor" class="form-control" placeholder="Masukkan Nama Vendor" value="<?= $row['nama_vendor'] ?>" required>                                                                        
                                </div>
                                <div class="mb-3">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" name="nama_barang" id="nama_barang" class="form-control" placeholder="Masukkan Nama Barang" value="<?= $row['nama_barang'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kontak">Nomor Kontak</label>
                                    <input type="number" name="kontak" id="kontak" class="form-control" placeholder="Masukkan Nomor Kontak" value="<?= $row['kontak'] ?>" required>
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