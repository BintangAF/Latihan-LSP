<?php require_once '../layout/header.php'; ?>
<?php

// Barang saat ini
if(!isset($_GET['id_barang']) || empty($_GET['id_barang'])) {
    die("ID Barang tidak ditemukan atau kosong");
}

$id_barang = $_GET['id_barang'];

$stmt_barang = $conn->prepare("SELECT * FROM barang WHERE id_barang = ?");
$stmt_barang->bind_param('i', $id_barang);

if(!$stmt_barang->execute()) {
    die("Gagal Mengambil Data Barang Saat ini");
}

$result_barang = $stmt_barang->get_result();
$stmt_barang->close();
$row_barang = $result_barang->fetch_assoc();

if(!isset($_GET['id_vendor']) || empty($_GET['id_vendor'])) {
    die("Sepertinya Anda Belum Memilih Vendor!");
}

$id_vendor = $_GET['id_vendor'];

// Vendor
$stmt_vendor = $conn->prepare("SELECT nama_vendor FROM vendor WHERE id_vendor = ?");
$stmt_vendor->bind_param('i', $id_vendor);

if(!$stmt_vendor->execute()) {
    die("Gagal Mengambil Data Vendor");
}

$result_vendor = $stmt_vendor->get_result();
$stmt_vendor->close();
$row_vendor = $result_vendor->fetch_assoc();

// Barang Vendor & Gudang
$sql_barang_v = "SELECT id_barang_vendor, nama_barang FROM barang_vendor WHERE id_vendor = ? ORDER BY created_at DESC"; 
$sql_gudang = "SELECT * FROM gudang"; 

$stmt_barang_v = $conn->prepare($sql_barang_v);
$stmt_barang_v->bind_param('i', $id_vendor);

$stmt_gudang = $conn->prepare($sql_gudang);

if(!$stmt_barang_v->execute()) {
    die("Gagal Mengambil Data Barang Vendor");
}

$result_barang_v = $stmt_barang_v->get_result();
$stmt_barang_v->close();

if(!$stmt_gudang->execute()) {
    die("Gagal Mengambil Data Barang Vendor");
}

$result_gudang = $stmt_gudang->get_result();
$stmt_gudang->close();

?>

<section class="mt-3" id="content">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Update Barang</h3>
                        <div>
                            <a href="kelola_barang.php" class="btn btn-primary">Daftar Barang</a>
                            <a href="pilih_vendor.php?id_vendor=<?= $id_vendor ?>&id_barang=<?= $id_barang ?>" class="btn btn-secondary">Ubah Vendor</a>
                        </div>
                    </div>
                    <form action="../../system/crud/barang.php" method="post">
                        <input type="hidden" name="act" value="update">                        
                        <input type="hidden" name="id_barang" value="<?= $id_barang ?>">                        
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">                                    
                                    <label for="id_barang_vendor">Nama Barang</label>
                                    <select name="id_barang_vendor" class="form-select" id="id_barang_vendor">
                                        <?php while($row_barang_v = $result_barang_v->fetch_assoc()) : ?>
                                            <?php if($row_barang_v['id_barang_v'] == $row_barang['id_barang_v']) : ?>
                                            <option value="<?= $row_barang_v['id_barang_vendor'] ?>" selected><?= $row_barang_v['nama_barang'] ?></option>
                                            <?php else : ?>
                                            <option value="<?= $row_barang_v['id_barang_vendor'] ?>"><?= $row_barang_v['nama_barang'] ?></option>
                                            <?php endif; ?>
                                        <?php endwhile; ?>
                                    </select>                                    
                                    <span><small><em>Dari Vendor <b><?= $row_vendor['nama_vendor'] ?></b></em></small></span>
                                </div>

                                <div class="col-12">
                                    <label for="id_gudang">Gudang</label>
                                    <select name="id_gudang" class="form-select" id="id_gudang">
                                        <?php while($row_gudang = $result_gudang->fetch_assoc()) : ?>
                                            <?php if($row_gudang['id_gudang'] == $row_barang['id_gudang']) : ?>
                                            <option value="<?= $row_gudang['id_gudang'] ?>" selected><?= $row_gudang['nama_gudang'] ?>, <?= $row_gudang['lokasi_gudang'] ?></option>
                                            <?php else : ?>
                                            <option value="<?= $row_gudang['id_gudang'] ?>"><?= $row_gudang['nama_gudang'] ?>, <?= $row_gudang['lokasi_gudang'] ?></option>
                                            <?php endif; ?>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                
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