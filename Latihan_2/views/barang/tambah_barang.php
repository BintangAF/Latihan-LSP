<?php require_once '../layout/header.php'; ?>
<?php
if(!isset($_GET['nama_vendor']) || empty($_GET['nama_vendor'])) {
    echo "Harap Pilih Vendor Dahulu!";
    exit;
}

$nama_vendor = $_GET['nama_vendor'];

$stmt_vendor = $conn->prepare("SELECT nama_barang FROM vendor WHERE nama_vendor = ?");
$stmt_gudang = $conn->prepare("SELECT * FROM gudang");

$stmt_vendor->bind_param("s", $nama_vendor);
if(!$stmt_vendor->execute()) {
    echo "gagal mengambil data vendor";
}

$result_vendor = $stmt_vendor->get_result();
$stmt_vendor->close();

if(!$stmt_gudang->execute()) {
    echo "gagal mengambil data gudang";
}

$result_gudang = $stmt_gudang->get_result();
$stmt_gudang->close();

?>


<section class="mt-5" id="content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Tambah Data Vendor</h3>
                        <a href="kelola_vendor.php" class="btn btn-primary">Daftar Vendor</a>
                    </div>                    
                    <form action="../../system/crud/barang.php" method="post">
                        <input type="hidden" name="act" value="insert">
                        <input type="hidden" name="barcode" value="<?= rand(1, 999999999); ?>">
                        <input type="hidden" name="nama_vendor" value="<?= $nama_vendor ?>">
                        <div class="card-body">
                            <!-- <div class="row">
                                <form action="kelola_Vendor.php" method="get">
                                    <div class="input-group mb-3 w-25 float-end">
                                        <input type="text" name="s" class="form-control" id="pencarian" placeholder="Cari Nama Barang">
                                        <button type="button" class="btn btn-outline-secondary">Cari</button>
                                    </div>
                                </form>
                            </div>  -->
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-2">
                                        <label for="nama_barang">Nama Barang</label>
                                        <select name="nama_barang" class="form-select" id="nama_barang">
                                            <?php while($row_vendor = $result_vendor->fetch_assoc()) : ?>
                                            <option value="<?= $row_vendor['nama_barang'] ?>"><?= $row_vendor['nama_barang'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-2">
                                        <label for="id_gudang">Pilih Gudang</label>
                                        <select name="id_gudang" class="form-select" id="id_gudang">
                                            <?php while($row_gudang = $result_gudang->fetch_assoc()) : ?>
                                            <option value="<?= $row_gudang['id_gudang'] ?>"><?= $row_gudang['nama_gudang'] ?>, <?= $row_gudang['lokasi_gudang'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-2">
                                        <label for="jenis_barang">Jenis Barang</label>
                                        <input type="text" name="jenis_barang" class="form-control" id="jenis_barang" placeholder="Masukkan Jenis Barang" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-2">
                                        <label for="stok">Stok</label>
                                        <input type="number" name="stok" class="form-control" id="stok" placeholder="Masukkan Stok" required>
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
<?php require_once '../layout/footer.php'; ?>