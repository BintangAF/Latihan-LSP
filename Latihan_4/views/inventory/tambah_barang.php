<?php require_once '../layout/header.php'; ?>

<?php

$sql_barang = "SELECT id_vendor, nama_barang, nama_vendor FROM vendor"; 
$sql_storage = "SELECT * FROM storage_unit"; 

$stmt_barang = $conn->prepare($sql_barang);
$stmt_storage = $conn->prepare($sql_storage);

if(!$stmt_barang->execute()) {
    die("Gagal mengambil data barang");
}

$result_barang = $stmt_barang->get_result();
$stmt_barang->close();

if(!$stmt_storage->execute()) {
    die("Gagal mengambil data barang");
}

$result_storage = $stmt_storage->get_result();
$stmt_storage->close();

?>

<section class="mt-3" id="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Tambah Data Barang</h3>                        
                        <a href="kelola_inventory.php" class="btn btn-primary">Daftar Barang</a>                        
                    </div>
                    <form action="../../system/crud/inventory.php" method="post">
                        <input type="hidden" name="act" value="insert">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="nama_barang">Nama Barang</label>
                                    <select name="nama_barang" id="nama_barang" class="form-select" required>
                                        <option value="" selected>--Pilih Barang--</option>
                                        <?php while($row_barang = $result_barang->fetch_assoc()) : ?>
                                        <option value="<?= $row_barang['nama_barang'] ?>,<?= $row_barang['id_vendor'] ?>"><?= $row_barang['nama_barang'] ?>, <?= $row_barang['nama_vendor'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    
                                    <label for="jenis_barang">Jenis Barang</label>
                                    <input type="text" name="jenis_barang" id="jenis_barang" class="form-control" placeholder="Masukkan Jenis Barang" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="id_gudang">Nama Barang</label>
                                    <select name="id_gudang" id="id_gudang" class="form-select" required>
                                        <option value="" selected>--Pilih Gudang--</option>
                                        <?php while($row_storage = $result_storage->fetch_assoc()) : ?>
                                        <option value="<?= $row_storage['id_gudang'] ?>"><?= $row_storage['nama_gudang'] ?>, <?= $row_storage['lokasi_gudang'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    
                                    <label for="kuantitas">Kuantitas</label>
                                    <input type="number" name="kuantitas" id="kuantitas" class="form-control" placeholder="Masukkan Jumlah Kuantitas" required>
                                </div>                                
                            </div>
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