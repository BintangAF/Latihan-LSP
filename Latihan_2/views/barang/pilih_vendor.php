<?php require_once '../layout/header.php'; ?>
<?php

if(isset($_GET['act']) && !empty($_GET['act']) && $_GET['act'] == "update" &&
    isset($_GET['id_barang']) && !empty($_GET['id_barang'])    
) {
    $update = true;
    $id_barang = $_GET['id_barang'];
}

$stmt = $conn->prepare("SELECT DISTINCT nama_vendor FROM vendor");

if(!$stmt->execute()) {
    echo "gagal mengambil data";
}

$result = $stmt->get_result();

?>

<section class="mt-5" id="content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Pilih Vendor</h3>
                        <a href="kelola_barang.php" class="btn btn-primary">Daftar Barang</a>
                    </div>                    
                    <form action="<?= (!isset($update) || empty($update)) ? 'tambah_barang.php' : 'update_barang.php'; ?>" method="get">                                                
                        <?php if(isset($update) && !empty($update)) :?>
                            <input type="hidden" name="id_barang" value="<?= $id_barang ?>">
                        <?php endif;?>

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
                                <div class="col-12">
                                    <label for="nama_vendor">Pilih Vendor</label>
                                    <select name="nama_vendor" id="nama_vendor" class="form-select">
                                        <?php while($row = $result->fetch_assoc()) : ?>
                                        <option value="<?= $row['nama_vendor'] ?>"><?= $row['nama_vendor'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>                                
                            </div> 
                        </div>                                            
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lanjut</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once '../layout/footer.php'; ?>