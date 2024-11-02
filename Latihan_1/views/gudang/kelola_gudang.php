<?php
require_once '../../koneksi.php';

$stmt = $conn->prepare("SELECT * FROM gudang"); 

if(!$stmt->execute()) {
    echo "Gagal mengambil data";
    exit;
}

$result = $stmt->get_result();

?>

<?php  require_once '../layout/header.php';?>

<section class="pt-3" id="content">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Gudang</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Daftar Gudang</h3>
                        <a href="tambah_gudang.php" class="btn btn-primary">Tambah Gudang</a>
                    </div>
                    <div class="card-body">
                        <!-- <form action="" method="get">
                            <div class="col-12 input-group mb-3 w-25 float-end">
                                <input type="text" name="s" class="form-control" placeholder="Cari Nama Barang...">
                                <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            </div>                            
                        </form> -->
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>                                        
                                        <th scope="col">Nama Gudang</th>
                                        <th scope="col">Lokasi Gudang</th>
                                        <th scope="col">Aksi</th>
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
                                            <a href="update_gudang.php?lokasi_gudang_lama=<?= $row['lokasi_gudang'] ?>" class="btn btn-primary">Update</a>
                                            <a href="../../system/crud/crud_gudang.php?act=delete&lokasi_gudang=<?= $row['lokasi_gudang'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?');">Hapus</a>
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

<?php  require_once '../layout/footer.php';?>
