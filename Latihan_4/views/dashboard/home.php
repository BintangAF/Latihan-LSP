<?php require_once '../layout/header.php'; ?>

<?php

$sql_barang = "SELECT inventory.*, 
                vendor.nama_vendor,
                storage_unit.nama_gudang,
                storage_unit.lokasi_gudang
                FROM inventory 
                JOIN vendor ON vendor.id_vendor = inventory.id_vendor
                JOIN storage_unit ON storage_unit.id_gudang = inventory.id_gudang
                WHERE DATE(inventory.created_at) = CURDATE()
                ORDER BY created_at DESC
                ";

$sql_gudang = "SELECT COUNT(*) AS jum_barang_di_gudang 
                FROM inventory
                JOIN storage_unit ON storage_unit.id_gudang = inventory.id_gudang
                ";

$sql_vendor = "SELECT COUNT(DISTINCT nama_vendor) AS jumlah_vendor FROM vendor";

$sql_stok = "SELECT inventory.*,
            vendor.nama_vendor
            FROM inventory 
            JOIN vendor ON vendor.id_vendor = inventory.id_vendor
            WHERE kuantitas <= 5";

$stmt_barang = $conn->prepare($sql_barang);
$stmt_gudang = $conn->prepare($sql_gudang);
$stmt_vendor = $conn->prepare($sql_vendor);
$stmt_stok = $conn->prepare($sql_stok);

// Barang

if(!$stmt_barang->execute()) {
    die("Gagal mengambil data barang yang baru masuk");
}

$result_barang = $stmt_barang->get_result();
$stmt_barang->close();
$jum_barang_baru_masuk = $result_barang->num_rows;

// Gudang

if(!$stmt_gudang->execute()) {
    die("Gagal mengambil data barang yang terdapat di gudang");
}

$result_gudang = $stmt_gudang->get_result();
$stmt_gudang->close();
$row_gudang = $result_gudang->fetch_assoc();

// Vendor

if(!$stmt_vendor->execute()) {
    die("Gagal mengambil data vendor");
}

$result_vendor = $stmt_vendor->get_result();
$stmt_vendor->close();
$row_vendor = $result_vendor->fetch_assoc();

// Stok

if(!$stmt_stok->execute()) {
    die("Gagal mengambil data barang dengan stok menipis");
}

$result_stok = $stmt_stok->get_result();
$stmt_stok->close();
$jum_barang_stok_tipis = $result_stok->num_rows;

?>

<section class="mt-3" id="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="card text-bg-info">
                    <div class="card-body">
                        <div class="card-title">
                            <h6>Barang yang baru masuk</h6>
                        </div>
                        <div class="card-text">
                            <h1><?= $jum_barang_baru_masuk ?></h1>
                        </div>
                    </div>
                </div>            
            </div>
            <div class="col-3">
                <div class="card text-bg-success">
                    <div class="card-body">
                        <div class="card-title">
                            <h6>Total Barang di Gudang</h6>
                        </div>
                        <div class="card-text">
                            <h1><?= $row_gudang['jum_barang_di_gudang'] ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card text-bg-light">
                    <div class="card-body">
                        <div class="card-title">
                            <h6>Total Vendor</h6>
                        </div>
                        <div class="card-text">
                            <h1><?= $row_vendor['jumlah_vendor'] ?></h1>
                        </div>
                    </div>
                </div>
            </div>           
            <div class="col-3">
                <div class="card text-bg-danger">
                    <div class="card-body">
                        <div class="card-title">
                            <h6>Barang dengan stok menipis</h6>
                        </div>
                        <div class="card-text">
                            <h1><?= $jum_barang_stok_tipis ?></h1>
                        </div>
                    </div>
                </div>
            </div>           
        </div>
        <div class="row mt-4">
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Barang yang baru Masuk</h4>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Kuantitas</th>
                                    <th>Nama Vendor</th>
                                    <th>Nama Gudang</th>
                                    <th>Lokasi Gudang</th>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php while($row_barang = $result_barang->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $row_barang['nama_barang'] ?></td>
                                        <td><?= $row_barang['jenis_barang'] ?></td>
                                        <td><?= $row_barang['kuantitas'] ?></td>
                                        <td><?= $row_barang['nama_vendor'] ?></td>
                                        <td><?= $row_barang['nama_gudang'] ?></td>
                                        <td><?= $row_barang['lokasi_gudang'] ?></td>
                                    </tr>
                                    <?php $i++; ?>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="accordion" id="accordionStok">
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button type="button" class="accordion-button collapsed bg-danger-subtle" data-bs-toggle="collapse" data-bs-target="#collapseFirst" aria-expanded="false" aria-controls="collapseFirst">
                                Daftar Barang dengan Stok Menipis
                            </button>
                        </h4>
                        <div id="collapseFirst" class="accordion-collapse collapse" data-bs-parents="#accordionStok">
                            <div class="accordion-body">
                                <?php $i = 1; ?>
                                <?php while($row_stok = $result_stok->fetch_assoc()) : ?>
                                    <p><?= $i ?>. <a class="link-danger" href="../inventory/update_barang.php?id_barang=<?= $row_stok['id_barang'] ?>"><?= $row_stok['nama_barang'] ?>, <?= $row_stok['nama_vendor'] ?></a></p>
                                <?php $i++; ?>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../layout/footer.php'; ?>