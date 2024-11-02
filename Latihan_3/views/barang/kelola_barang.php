<?php require_once '../layout/header.php'; ?>
<?php

// Logika Ambil barang yang stok nya habis
$sql_stok_habis = 
    "SELECT 
        barang_vendor.*,
        vendor.*        
    FROM barang_vendor    
    JOIN vendor ON vendor.id_vendor = barang_vendor.id_vendor        
    WHERE barang_vendor.stok < 1
";

$stmt_stok_habis = $conn->prepare($sql_stok_habis);

if(!$stmt_stok_habis->execute()) {
    die("Gagal ambil data barang yang stok nya habis.");
}

$result_stok_habis = $stmt_stok_habis->get_result();

// Logika Barang
$sql = "SELECT barang.*,
        barang_vendor.*,
        vendor.*,
        gudang.*
        FROM barang
        JOIN barang_vendor ON barang_vendor.id_barang_vendor = barang.id_barang_vendor
        JOIN vendor ON vendor.id_vendor = barang_vendor.id_vendor
        JOIN gudang ON gudang.id_gudang = barang.id_gudang
        ORDER BY barang.updated_at DESC
";

$stmt = $conn->prepare($sql);

if(!$stmt->execute()) {
    die("Gagal Mengambil data");
}

$result = $stmt->get_result();

// Logika Pencarian
if(isset($_GET['s']) && !empty($_GET['s'])) {
    $searched = '%'. $_GET['s'] . '%';

    $sql_pencarian = "SELECT barang.*,
        barang_vendor.*,
        vendor.*,
        gudang.*
        FROM barang
        JOIN barang_vendor ON barang_vendor.id_barang_vendor = barang.id_barang_vendor
        JOIN vendor ON vendor.id_vendor = barang_vendor.id_vendor
        JOIN gudang ON gudang.id_gudang = barang.id_gudang
        WHERE barang_vendor.nama_barang LIKE ?
        ORDER BY barang.updated_at DESC
";

    $stmt_pencarian = $conn->prepare($sql_pencarian);
    $stmt_pencarian->bind_param('s', $searched);

    if(!$stmt_pencarian->execute()) {
        die("Gagal mengambil data pencarian");
    }

    $result_pencarian = $stmt_pencarian->get_result();
}

?>


<section class="mt-3" id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(isset($result_stok_habis) && $result_stok_habis->num_rows > 0) : ?>
                    <div class="accordion mb-2" id="accordionStok">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStok">Daftar Barang yang Stok nya Habis</button>
                            </h2>
                            <div id="collapseStok" class="accordion-collapse collapse" data-bs-parent="#accordionStok">
                                <div class="accordion-body">
                                    <?php $i = 1; ?>
                                    <?php while($row_stok_habis = $result_stok_habis->fetch_assoc()) : ?>
                                        <p><?= $i ?>. <a href="../barang_vendor/update_barang_v.php?id_vendor=<?= $row_stok_habis['id_vendor'] ?>&id_barang_vendor=<?= $row_stok_habis['id_barang_vendor'] ?>"><?= $row_stok_habis['nama_barang'] ?>, <b><?= $row_stok_habis['nama_vendor'] ?></b></a></p>
                                    <?php $i++; ?>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Daftar Barang</h3>
                        <a href="pilih_vendor.php" class="btn btn-primary">Tambah Barang</a>
                    </div>
                    <div class="card-body">                        
                        <div class="row">
                        <form action="kelola_barang.php" method="get">                                
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
                                        <th>Nama Vendor</th>
                                        <th>Nama Gudang</th>
                                        <th>Lokasi Gudang</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php if(!isset($_GET['s']) || empty($_GET['s'])) : ?>
                                            <?php while($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $row['nama_barang'] ?></td>
                                                <td>Rp. <?= $row['harga'] ?></td>
                                                <td><?= $row['stok'] ?></td>
                                                <td><?= $row['nama_vendor'] ?></td>
                                                <td><?= $row['nama_gudang'] ?></td>
                                                <td><?= $row['lokasi_gudang'] ?></td>
                                                <td>
                                                    <a href="update_barang.php?id_vendor=<?= $row['id_vendor'] ?>&id_barang=<?= $row['id_barang'] ?>" class="btn btn-primary">Edit</a>
                                                    <a href="../barang_vendor/update_barang_v.php?id_vendor=<?= $row['id_vendor'] ?>&id_barang_vendor=<?= $row['id_barang_vendor'] ?>" class="btn btn-warning">Edit Info</a>
                                                    <a href="../../system/crud/barang.php?act=delete&id_barang=<?= $row['id_barang'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?')">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                            <?php endwhile; ?>
                                        <?php else : ?>
                                            <?php while($row_pencarian = $result_pencarian->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $row_pencarian['nama_barang'] ?></td>
                                                <td>Rp. <?= $row_pencarian['harga'] ?></td>
                                                <td><?= $row_pencarian['stok'] ?></td>
                                                <td><?= $row_pencarian['nama_vendor'] ?></td>
                                                <td><?= $row_pencarian['nama_gudang'] ?></td>
                                                <td><?= $row_pencarian['lokasi_gudang'] ?></td>
                                                <td>
                                                    <a href="update_barang.php?id_vendor=<?= $row_pencarian['id_vendor'] ?>&id_barang=<?= $row_pencarian['id_barang'] ?>" class="btn btn-primary">Edit</a>
                                                    <a href="../barang_vendor/update_barang_v.php?id_vendor=<?= $row_pencarian['id_vendor'] ?>&id_barang_vendor=<?= $row_pencarian['id_barang_vendor'] ?>" class="btn btn-warning">Edit Info</a>
                                                    <a href="../../system/crud/barang.php?act=delete&id_barang=<?= $row_pencarian['id_barang'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?')">Hapus</a>
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

<?php require_once '../layout/footer.php'; ?>