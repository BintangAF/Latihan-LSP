<?php require_once '../../system/authentication/auth_check.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap-5.3.3/css/bootstrap.min.css">
    <title>Manajemen Invetori</title>
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-lg bg-primary" aria-label="Thirteenth navbar example">
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
                    <a class="btn btn-danger" href="../../system/logout/logout.php" onclick="return confirm('Anda Yakin?');">Log Out</a>
                </div>
            </div>
        </div>
    </nav>