<?php require_once '../layout/header.php'; ?>
<?php

if(isset($_GET['id_barang']) && !empty($_GET['id_barang']) && 
    isset($_GET['id_vendor']) && !empty($_GET['id_vendor'])) {    
    $id_barang = $_GET['id_barang'];
    $id_vendor = $_GET['id_vendor'];
}

$stmt = $conn->prepare("SELECT id_vendor, nama_vendor FROM vendor");

if(!$stmt->execute()) {
    die("Gagal mengambil data");
}

$result = $stmt->get_result();

?>

<section class="mt-3" id="content">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Pilih Vendor</h3>
                        <a href="kelola_barang.php" class="btn btn-primary">Daftar Barang</a>
                    </div>
                    <form action="<?= (!isset($id_barang) || !isset($id_vendor)) ? "tambah_barang.php" : "update_barang.php";?>" method="get">
                    <?php if(isset($id_barang)) : ?>                                                                        
                        <input type="hidden" name="id_barang" value="<?= $id_barang ?>">                        
                    <?php endif; ?>                        
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="id_vendor">Vendor</label>
                                    <select name="id_vendor" class="form-select" id="id_vendor">
                                        <?php while($row = $result->fetch_assoc()) : ?>
                                        <option value="<?= $row['id_vendor'] ?>"><?= $row['nama_vendor'] ?></option>
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
            </div>
        </div>
    </div>
</section>

<?php require_once '../layout/footer.php'; ?>