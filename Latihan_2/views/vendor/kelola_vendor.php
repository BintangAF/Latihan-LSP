<?php require_once '../layout/header.php'; ?>
<?php

$sql = "SELECT * FROM vendor";

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
                        <h3>Daftar Vendor</h3>
                        <a href="tambah_vendor.php" class="btn btn-primary">Tambah Vendor</a>
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
                                            <td>Nama Vendor</td>
                                            <td>Nama Barang</td>                                            
                                            <td>Kontak</td>
                                            <td>Nomor Invoice</td>                                            
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php while($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $row['nama_vendor'] ?></td>
                                            <td><?= $row['nama_barang'] ?></td>
                                            <td><?= $row['kontak'] ?></td>
                                            <td><?= $row['nomor_invoice'] ?></td>                                            
                                            <td>
                                                <a href="update_vendor.php?nomor_invoice=<?= $row['nomor_invoice'] ?>" class="btn btn-primary">Edit</a>
                                                <a href="../../system/crud/vendor.php?act=delete&nomor_invoice=<?= $row['nomor_invoice'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?');">Hapus</a>
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