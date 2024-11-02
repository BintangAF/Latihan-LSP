<?php

require_once '../../koneksi.php';

if(!isset($_POST['nama_vendor']) || empty($_POST['nama_vendor'])) {
    echo "nama vendor tidak ditemukan";
    exit;
}

$nama_vendor = $_POST['nama_vendor'];

$sql_vendor = "SELECT nama_barang FROM vendor WHERE nama_vendor = ?";
$sql_gudang = "SELECT * FROM gudang";

$stmt_vendor = $conn->prepare($sql_vendor);
$stmt_vendor->bind_param('s', $nama_vendor);
$stmt_gudang = $conn->prepare($sql_gudang);

if(!$stmt_vendor->execute()) {
    echo "gagal mengambil data vendor";
    exit;
}

$result_vendor = $stmt_vendor->get_result();
$stmt_vendor->close();

if(!$stmt_gudang->execute()) {
    echo "gagal mengambil data gudang";
    exit;
}

$result_gudang = $stmt_gudang->get_result();
$stmt_gudang->close();

?>
<?php  require_once '../layout/header.php';?>

<section class="pt-3" id="content">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Barang</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Form Tambah Barang</h3>
                        <a href="kelola_barang.php" class="btn btn-primary">Daftar Barang</a>
                    </div>
                    <form action="../../system/crud/crud_barang.php" method="post">
                    <div class="card-body">
                        <!-- <form action="" method="get">
                            <div class="col-12 input-group mb-3 w-25 float-end">
                                <input type="text" name="s" class="form-control" placeholder="Cari Nama Barang...">
                                <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            </div>                            
                        </form> -->
                        <div class="col-12">
                            
                            <input type="hidden" name="act" value="insert">

                            <input type="hidden" name="barcode" value="<?= rand(1,8) ?>">
                        
                                <div class="row">
                                    <div class="col-6 mb-3">

                                        <label class="form-label" for="namaBarang">Nama Barang</label>
                                        <select class="form-select" name="nama_barang" id="namaBarang" required>
                                            <option value="" selected>-- Pilih Nama Barang --</option>
                                        <?php while($row_vendor = $result_vendor->fetch_assoc()) : ?>
                                            <option value="<?= $row_vendor['nama_barang'] ?>"><?= $row_vendor['nama_barang'] ?></option>    
                                        <?php endwhile; ?>
                                        </select>

                                        <label class="form-label" for="jenisBarang">Jenis Barang</label>
                                        <input type="text" class="form-control" name="jenis_barang" id="jenisBarang" placeholder="Masukkan Jenis Barang" maxlength="30" required>
                                        
                                    </div>                                    
                                    <div class="col-6 mb-3">
                                        <label class="form-label" for="stok">Stok</label>
                                        <input type="number" class="form-control" name="stok" id="stok" placeholder="Masukkan Jumlah Stok" min="0" max="99" step="1" maxlength="2" required>

                                        <label class="form-label" for="lokasiGudang">Lokasi Gudang</label>
                                        <select class="form-select" name="lokasi_gudang" id="lokasiGudang" required>
                                            <option value="" selected>-- Pilih Lokasi Gudang --</option>
                                        <?php while($row_gudang = $result_gudang->fetch_assoc()) : ?>
                                            <option value="<?= $row_gudang['lokasi_gudang'] ?>"><?= $row_gudang['lokasi_gudang'] ?></option>    
                                        <?php endwhile; ?>
                                        </select>

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
