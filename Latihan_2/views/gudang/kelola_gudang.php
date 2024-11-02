<?php require_once '../layout/header.php'; ?>
<?php

$sql = "SELECT * FROM gudang";

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
                        <h3>Daftar Gudang</h3>
                        <a href="tambah_gudang.php" class="btn btn-primary">Tambah Gudang</a>
                    </div>                    
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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Nama Gudang</td>
                                            <td>Lokasi Gudang</td>                                                                                        
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
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
    </div>
</section>
<?php require_once '../layout/footer.php'; ?>