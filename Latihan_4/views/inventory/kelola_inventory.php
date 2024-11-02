<?php require_once '../layout/header.php'; ?>

<?php

$sql = "SELECT inventory.*,
        vendor.nama_vendor,
        storage_unit.nama_gudang,
        storage_unit.lokasi_gudang
        FROM inventory 
        JOIN vendor ON vendor.id_vendor = inventory.id_vendor
        JOIN storage_unit ON storage_unit.id_gudang = inventory.id_gudang
        ORDER BY updated_at DESC";

$stmt = $conn->prepare($sql);

if(!$stmt->execute()) {
    die("Gagal mengambil data storage unit");
}

$result = $stmt->get_result();

?>

<section class="mt-3" id="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Daftar Barang</h3>                        
                        <a href="tambah_barang.php" class="btn btn-primary">Tambah Barang</a>                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Kuantitas</th>                                    
                                    <th>Nama Vendor</th>                                    
                                    <th>Nama Gudang</th>                                    
                                    <th>Lokasi Gudang</th>                                    
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php while($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $row['nama_barang'] ?></td>
                                        <td><?= $row['jenis_barang'] ?></td>
                                        <td><?= $row['kuantitas'] ?></td>
                                        <td><?= $row['nama_vendor'] ?></td>
                                        <td><?= $row['nama_gudang'] ?></td>
                                        <td><?= $row['lokasi_gudang'] ?></td>                                        
                                        <td>
                                            <a href="update_barang.php?id_barang=<?= $row['id_barang'] ?>" class="btn btn-success">Update</a>
                                            <a href="../../system/crud/inventory.php?act=delete&id_barang=<?= $row['id_barang'] ?>" class="btn btn-danger" onclick="return confirm('Anda yakin?')">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
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