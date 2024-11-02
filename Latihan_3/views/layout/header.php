<?php require_once '../../system/init.php'; ?>
<?php

// Logika Stok Habis
$stmt_stok = $conn->prepare("SELECT nama_barang FROM barang_vendor WHERE stok < 1");

if(!$stmt_stok->execute()) {
    die("Gagal mengambil data barang yang stoknya habis");
}

$result_stok = $stmt_stok->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap-5.3.3/css/bootstrap.min.css">
    <title>Manajemen Inventori</title>
</head>
<body>

    <nav class="navbar navbar-dark navbar-expand-lg bg-primary">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
          <a class="navbar-brand col-lg-3 me-0" href="#">Manajemen Inventori</a>
          <ul class="navbar-nav col-lg-6 justify-content-lg-center">
            <li class="nav-item">
              <a class="nav-link" href="../barang/kelola_barang.php">Barang</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../gudang/kelola_gudang.php">Gudang</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../vendor/kelola_vendor.php">Vendor</a>
            </li>            
          </ul>
          <div class="d-lg-flex col-lg-3 justify-content-lg-end">
            <a href="../../system/login/logout.php" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </div>
    </nav>
    
    <?php if($result_stok->num_rows > 0) : ?>
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastStokHabis" class="toast text-bg-danger" role="alert" data-bs-delay="5000" data-bs-autohide="true" data-bs-animation="true" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <strong class="me-auto">Peringatan</strong>            
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            Ada Barang yang stok nya habis.
          </div>
        </div>
      </div>
    <?php endif; ?>
    
