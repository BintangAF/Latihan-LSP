<?php require_once '../layout/header.php'; ?>
<?php

// Logika Alert jika stok habis
$stmt_stok = $conn->prepare("SELECT nama_barang FROM barang WHERE stok <= 0"); 

if(!$stmt_stok->execute()) {
    echo "gagal eksekusi queri stok";
    exit;
}

$result_stok = $stmt_stok->get_result();
$stmt_stok->close();

// Logika Pencarian
if(isset($_GET['s']) && !empty($_GET['s'])) {
    $searched = '%' . $_GET['s'] . '%';

    $sql_pencarian = "SELECT barang.*,
        gudang.nama_gudang,
        gudang.lokasi_gudang        
        FROM barang
        JOIN gudang ON gudang.id_gudang = barang.id_gudang
        WHERE barang.nama_barang LIKE ?
        ";

    $stmt_pencarian = $conn->prepare($sql_pencarian);
    $stmt_pencarian->bind_param('s', $searched);

    if(!$stmt_pencarian->execute()) {
        echo "gagal eksekusi queri pencarian";
        exit;
    }

    $result_pencarian = $stmt_pencarian->get_result();
    $stmt_pencarian->close();
}


$sql = "SELECT barang.*,
        gudang.nama_gudang,
        gudang.lokasi_gudang        
        FROM barang
        JOIN gudang ON gudang.id_gudang = barang.id_gudang        
        ";

$stmt = $conn->prepare($sql);

if(!$stmt->execute()) {
    die("Gagal mengambil data");
} 

$result = $stmt->get_result();

?>


<section class="mt-2" id="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Daftar Barang</h3>
                        <a href="pilih_vendor.php" class="btn btn-primary">Tambah Barang</a>
                    </div>                    
                    <div class="card-body">
                        <div class="row">
                            <form action="kelola_barang.php" method="get">
                                <div class="input-group mb-3 w-25 float-end">
                                    <input type="text" name="s" class="form-control" id="pencarian" placeholder="Cari Nama Barang..." <?php if(isset($_GET['s'])) echo 'value="'. $_GET['s'] .'"';?>>
                                    <button type="button" class="btn btn-outline-secondary">Cari</button>
                                </div>
                            </form>
                        </div> 
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Nama Barang</td>
                                            <td>Jenis Barang</td>
                                            <td>Stok</td>
                                            <td>Barcode</td>
                                            <td>Nama Vendor</td>
                                            <td>Nama Gudang</td>
                                            <td>Lokasi Gudang</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php if(!isset($result_pencarian) || empty($result_pencarian) || empty($_GET['s'])) : ?>
                                            <?php while($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $row['nama_barang'] ?></td>
                                                <td><?= $row['jenis_barang'] ?></td>
                                                <td><?= $row['stok'] ?></td>
                                                <td><?= $row['barcode'] ?></td>
                                                <td><?= $row['nama_vendor'] ?></td>
                                                <td><?= $row['nama_gudang'] ?></td>
                                                <td><?= $row['lokasi_gudang'] ?></td>
                                                <td>
                                                    <a href="update_barang.php?id_barang=<?= $row['id_barang'] ?>" class="btn btn-primary">Edit</a>
                                                    <a href="../../system/crud/barang.php?act=delete&id_barang=<?= $row['id_barang'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?');">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                            <?php endwhile; ?>
                                        <?php else : ?>
                                            <?php while($row_pencarian = $result_pencarian->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $row_pencarian['nama_barang'] ?></td>
                                                <td><?= $row_pencarian['jenis_barang'] ?></td>
                                                <td><?= $row_pencarian['stok'] ?></td>
                                                <td><?= $row_pencarian['barcode'] ?></td>
                                                <td><?= $row_pencarian['nama_vendor'] ?></td>
                                                <td><?= $row_pencarian['nama_gudang'] ?></td>
                                                <td><?= $row_pencarian['lokasi_gudang'] ?></td>
                                                <td>
                                                    <a href="update_barang.php?id_barang=<?= $row_pencarian['id_barang'] ?>" class="btn btn-primary">Edit</a>
                                                    <a href="../../system/crud/barang.php?act=delete&id_barang=<?= $row_pencarian['id_barang'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?');">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>                                            
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Logika alert
    <?php if($result_stok->num_rows > 0) : ?>                                
        let text = "Stok barang yang habis :";
        <?php while($row = $result_stok->fetch_assoc()) : ?>
            text += "\n" + "<?= $row['nama_barang'] ?>";
        <?php endwhile; ?>

        alert(text);
    <?php endif; ?>                                
</script>

<?php require_once '../layout/footer.php'; ?>