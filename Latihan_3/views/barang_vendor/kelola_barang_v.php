<?php require_once '../layout/header.php'; ?>
<?php

if(!isset($_GET['id_vendor']) || empty($_GET['id_vendor'])) {
    die("ID Vendor tidak ditemukan atau kosong");
}

$id_vendor = $_GET['id_vendor'];

$sql = "SELECT * FROM barang_vendor WHERE id_vendor = ? ORDER BY updated_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_vendor);

if(!$stmt->execute()) {
    die("Gagal Mengambil Data");
}

$result = $stmt->get_result();
$stmt->close();

$stmt_vendor = $conn->prepare("SELECT nama_vendor FROM vendor WHERE id_vendor = ?");
$stmt_vendor->bind_param('i', $id_vendor);

if(!$stmt_vendor->execute()) {
    die("Gagal Mengambil Data");
}

$result_vendor = $stmt_vendor->get_result();
$stmt_vendor->close();
$row_vendor = $result_vendor->fetch_assoc();

// Logika Pencarian
if(isset($_GET['s']) && !empty($_GET['s'])) {
    $searched = '%'. $_GET['s'] . '%';

    $sql_pencarian = "SELECT * 
                    FROM barang_vendor 
                    WHERE id_vendor = ? 
                    AND nama_barang LIKE ? 
                    ORDER BY updated_at DESC";

    $stmt_pencarian = $conn->prepare($sql_pencarian);
    $stmt_pencarian->bind_param('is', $id_vendor, $searched);

    if(!$stmt_pencarian->execute()) {
        die("Gagal mengambil data pencarian");
    }

    $result_pencarian = $stmt_pencarian->get_result();
}

?>

<section class="mt-3" id="content">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Daftar Barang Vendor ( <b><?= $row_vendor['nama_vendor'] ?></b> )</h3>
                        <div class="">
                            <a href="../vendor/kelola_vendor.php" class="btn btn-success">Daftar Vendor</a>
                            <a href="tambah_barang_v.php?id_vendor=<?= $id_vendor ?>" class="btn btn-primary">Tambah Barang</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">                            
                            <form action="kelola_barang_v.php" method="get">
                                <input type="hidden" name="id_vendor" value="<?= $id_vendor ?>">
                                <div class="input-group w-25 float-end mb-2">
                                    <input type="text" class="form-control" name="s" placeholder="Cari Barang..." <?php if(isset($_GET['s']) && !empty($_GET['s'])) echo 'value="'. $_GET['s'] .'"' ?>>
                                    <button type="submit" class="btn btn-outline-secondary">Cari</button>
                                </div>
                            </form>                            
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped table-bordered table-hover">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>                                    
                                        <th>Stok</th>                                    
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;?>
                                        <?php if(!isset($_GET['s']) || empty($_GET['s'])) : ?>
                                            <?php while($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $i ?></td>                                        
                                                <td><?= $row['nama_barang'] ?></td>
                                                <td>Rp. <?= $row['harga'] ?></td>
                                                <td><?= $row['stok'] ?></td>
                                                <td>                                            
                                                    <a href="update_barang_v.php?id_vendor=<?= $id_vendor ?>&id_barang_vendor=<?= $row['id_barang_vendor'] ?>" class="btn btn-primary">Edit</a>
                                                    <a href="../../system/crud/barang_vendor.php?act=delete&id_vendor=<?= $id_vendor ?>&id_barang_vendor=<?= $row['id_barang_vendor'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?');">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php $i++;?>
                                            <?php endwhile; ?>
                                        <?php else : ?>
                                            <?php while($row_pencarian = $result_pencarian->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $i ?></td>                                        
                                                <td><?= $row_pencarian['nama_barang'] ?></td>
                                                <td>Rp. <?= $row_pencarian['harga'] ?></td>
                                                <td><?= $row_pencarian['stok'] ?></td>
                                                <td>                                            
                                                    <a href="update_barang_v.php?id_vendor=<?= $id_vendor ?>&id_barang_vendor=<?= $row_pencarian['id_barang_vendor'] ?>" class="btn btn-primary">Edit</a>
                                                    <a href="../../system/crud/barang_vendor.php?act=delete&id_vendor=<?= $id_vendor ?>&id_barang_vendor=<?= $row_pencarian['id_barang_vendor'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?');">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php $i++;?>
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

<?php require_once '../layout/footer.php'; ?>