<?php
require_once '../../koneksi.php';

$sql_stok = "SELECT nama_barang FROM barang WHERE stok < 1";

$stmt_stok = $conn->prepare($sql_stok);

if(!$stmt_stok->execute()) {
    echo "Gagal mengambil data";
    exit;        
}

$result_stok = $stmt_stok->get_result();
$stmt_stok->close();

$row_stok = $result_stok->fetch_assoc();

// if($row_stok) {
//     echo "
//         <script>
//         alert('Terdapat Stok yang kosong');
//         </script>
    
//     ";
// }




if(isset($_GET['s']) && !empty($_GET['s'])) {
    $yang_dicari = $_GET['s']; 

    $sql_pencarian = 
        "SELECT barang.*,
        vendor.nama_vendor,
        gudang.nama_gudang
        FROM barang
        JOIN vendor ON vendor.nama_barang = barang.nama_barang
        JOIN gudang ON gudang.lokasi_gudang = barang.lokasi_gudang
        WHERE barang.nama_barang LIKE ?
    ";

    $yang_dicari = '%' . $yang_dicari . '%';  

    $stmt_pencarian = $conn->prepare($sql_pencarian);

    $stmt_pencarian->bind_param('s',$yang_dicari);


    if(!$stmt_pencarian->execute()) {
        echo "Gagal mengambil data yang disaring";
        exit;
    } 

    $result_pencarian = $stmt_pencarian->get_result();
    $stmt_pencarian->close();

}


$sql = "SELECT barang.*,
        vendor.nama_vendor,
        gudang.nama_gudang
        FROM barang
        JOIN vendor ON vendor.nama_barang = barang.nama_barang
        JOIN gudang ON gudang.lokasi_gudang = barang.lokasi_gudang
";

$stmt = $conn->prepare($sql);

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
                <h1 class="text-center">Barang</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Daftar Barang</h3>
                        <a href="pilih_vendor.php" class="btn btn-primary">Tambah Barang</a>
                    </div>
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="col-12 input-group mb-3 w-25 float-end">
                                <input type="text" name="s" class="form-control" placeholder="Cari Nama Barang..." <?php if(isset($_GET['s']) && !empty($_GET['s'])) echo 'value="'. $_GET['s'] .'"'; ?> maxlength="30">
                                <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            </div>                            
                        </form>
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Jenis Barang</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Vendor</th>
                                        <th scope="col">Nama Gudang</th>
                                        <th scope="col">Lokasi Gudang</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>                                    
                                <?php $i = 1 ?>
                                <?php if(!isset($_GET['s']) || empty($_GET['s'])) : ?>
                                    <?php while($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $row['nama_barang'] ?></td>
                                        <td><?= $row['jenis_barang'] ?></td>
                                        <td><?= $row['stok'] ?></td>
                                        <td><?= $row['nama_vendor'] ?></td>
                                        <td><?= $row['nama_gudang'] ?></td>
                                        <td><?= $row['lokasi_gudang'] ?></td>
                                        <td>
                                            <a href="update_barang.php?id_barang=<?= $row['id_barang'] ?>" class="btn btn-primary">Update</a>
                                            <a href="../../system/crud/crud_barang.php?act=delete&id_barang=<?= $row['id_barang'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?');">Hapus</a>
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
                                        <td><?= $row_pencarian['nama_vendor'] ?></td>
                                        <td><?= $row_pencarian['nama_gudang'] ?></td>
                                        <td><?= $row_pencarian['lokasi_gudang'] ?></td>
                                        <td>
                                            <a href="update_barang.php?id_barang=<?= $row_pencarian['id_barang'] ?>" class="btn btn-primary">Update</a>
                                            <a href="../../system/crud/crud_barang.php?act=delete&id_barang=<?= $row_pencarian['id_barang'] ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin?')">Hapus</a>
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
</section>

<?php  require_once '../layout/footer.php';?>

<script>
    
    if(<?= $row_stok ?>) {        
        alert('Terdapat Stok yang kosong');
    }
</script>