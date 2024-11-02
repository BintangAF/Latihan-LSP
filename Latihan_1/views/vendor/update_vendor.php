<?php
require_once '../../koneksi.php';

if(!isset($_GET['nomor_invoice']) || empty($_GET['nomor_invoice'])) {
    echo "nomor invoice tidak boleh kosong";
    exit;    
}

$nomor_invoice = $_GET['nomor_invoice'];

$sql = "SELECT * FROM vendor WHERE nomor_invoice = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param('i', $nomor_invoice);

if(!$stmt->execute()) {
    echo "Gagal Mengambil data";
    exit;
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>

<?php  require_once '../layout/header.php';?>

<section class="pt-3" id="content">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Vendor</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Form Update Vendor</h3>
                        <a href="kelola_vendor.php" class="btn btn-primary">Daftar Vendor</a>
                    </div>
                    <form action="../../system/crud/crud_vendor.php" method="post">
                    <div class="card-body">
                        <!-- <form action="" method="get">
                            <div class="col-12 input-group mb-3 w-25 float-end">
                                <input type="text" name="s" class="form-control" placeholder="Cari Nama Barang...">
                                <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            </div>                            
                        </form> -->
                        <div class="col-12">
                            
                            <input type="hidden" name="act" value="update">

                            <input type="hidden" name="nomor_invoice" value="<?= $nomor_invoice ?>">

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label" for="namaVendor">Nama Vendor</label>
                                        <input type="text" class="form-control" name="nama_vendor" id="namaVendor" placeholder="Masukkan Nama Vendor" value="<?= $row['nama_vendor'] ?>" maxlength="30" required>

                                        <label class="form-label" for="kontak">Kontak</label>
                                        <input type="number" class="form-control" name="kontak" id="kontak" placeholder="Masukkan Nomor Kontak" value="<?= $row['kontak'] ?>" min="0" maxlength="8" step="1" required>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="form-label" for="namaBarang">Nama Barang</label>
                                        <input type="text" class="form-control" name="nama_barang" id="namaBarang" placeholder="Masukkan Nama Barang" value="<?= $row['nama_barang'] ?>" maxlength="30" required>
                                    </div>                                    
                                </div>                            
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php  require_once '../layout/footer.php';?>
