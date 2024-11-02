<?php require_once '../layout/header.php'; ?>
<?php

$stmt = $conn->prepare("SELECT * FROM gudang ORDER BY updated_at DESC");

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
                        <h3>Daftar Gudang</h3>
                        <a href="tambah_gudang.php" class="btn btn-primary">Tambah Gudang</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped table-bordered table-hover">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Gudang</th>
                                    <th>Lokasi Gudang</th>                                    
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    <?php while($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $i ?></td>                                        
                                        <td><?= $row['nama_gudang'] ?></td>
                                        <td><?= $row['lokasi_gudang'] ?></td>
                                        <td>
                                            <a href="update_gudang.php?id_gudang=<?= $row['id_gudang'] ?>" class="btn btn-primary">Edit</a>
                                            <a href="../../system/crud/gudang.php?act=delete&id_gudang=<?= $row['id_gudang'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?');">Hapus</a>
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