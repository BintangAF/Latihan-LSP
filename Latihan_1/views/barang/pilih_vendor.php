<?php

require_once '../../koneksi.php';

$sql_vendor = "SELECT DISTINCT nama_vendor FROM vendor";

$stmt_vendor = $conn->prepare($sql_vendor);

if(!$stmt_vendor->execute()) {
    echo "gagal mengambil data vendor";
    exit;
}

$result_vendor = $stmt_vendor->get_result();
$stmt_vendor->close();

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
                    <form action="tambah_barang.php" method="post">
                    <div class="card-body">
                        <!-- <form action="" method="get">
                            <div class="col-12 input-group mb-3 w-25 float-end">
                                <input type="text" name="s" class="form-control" placeholder="Cari Nama Barang...">
                                <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            </div>                            
                        </form> -->
                        <div class="col-12">                                                                                    
                        
                                <div class="row">
                                    <div class="col-12 mb-3">

                                        <label class="form-label" for="namaVendor">Nama Vendor</label>
                                        <select class="form-select" name="nama_vendor" id="namaVendor" required>
                                            <option value="" selected>-- Pilih Nama Vendor --</option>
                                        <?php while($row_vendor = $result_vendor->fetch_assoc()) : ?>
                                            <option value="<?= $row_vendor['nama_vendor'] ?>"><?= $row_vendor['nama_vendor'] ?></option>    
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
