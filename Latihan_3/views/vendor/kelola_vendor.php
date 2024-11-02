<?php require_once '../layout/header.php'; ?>
<?php

$stmt = $conn->prepare("SELECT * FROM vendor ORDER BY updated_at DESC");

if(!$stmt->execute()) {
    die("Gagal Mengambil Data");
}

$result = $stmt->get_result();

?>

<section class="mt-3" id="content">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Daftar Vendor</h3>
                        <a href="tambah_vendor.php" class="btn btn-primary">Tambah Vendor</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped table-bordered table-hover">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Vendor</th>
                                    <th>Kontak</th>                                    
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    <?php while($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $i ?></td>                                        
                                        <td><?= $row['nama_vendor'] ?></td>
                                        <td><?= $row['kontak'] ?></td>
                                        <td>
                                            <a href="../barang_vendor/kelola_barang_v.php?id_vendor=<?= $row['id_vendor'] ?>" class="btn btn-success">Kelola Barang</a>
                                            <a href="update_vendor.php?id_vendor=<?= $row['id_vendor'] ?>" class="btn btn-primary">Edit</a>
                                            <a href="../../system/crud/vendor.php?act=delete&id_vendor=<?= $row['id_vendor'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?');">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php $i++;?>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../layout/footer.php'; ?>