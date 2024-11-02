<?php require_once '../layout/header.php'; ?>
<?php

if(!isset($_GET['id_vendor']) || empty($_GET['id_vendor'])) {
    die("ID Vendor tidak ditemukan atau kosong");
}

$id_vendor = $_GET['id_vendor'];

?>

<section class="mt-3" id="content">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Tambah Barang Vendor Baru</h3>
                        <a href="kelola_barang_v.php?id_vendor=<?= $id_vendor ?>" class="btn btn-primary">Daftar Barang Vendor</a>
                    </div>
                    <form action="../../system/crud/barang_vendor.php" method="post">
                        <input type="hidden" name="act" value="insert">
                        <input type="hidden" name="id_vendor" value="<?= $id_vendor ?>">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Masukkan Nama Barang" required>                                
                                </div>

                                <div class="col-6">
                                    <label for="harga" class="form-label">Harga</label>
                                    <div class="input-group">                                        
                                        <span class="input-group-text">Rp. </span>
                                        <input type="number" class="form-control" name="harga" id="harga" placeholder="Masukkan Harga" required>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="stok">Stok</label>                                    
                                    <input type="number" class="form-control" name="stok" id="stok" placeholder="Masukkan Jumlah Stok" required>                                    
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