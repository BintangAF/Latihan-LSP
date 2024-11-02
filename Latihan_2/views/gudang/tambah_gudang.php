<?php require_once '../layout/header.php'; ?>

<section class="mt-5" id="content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Tambah Data Gudang</h3>
                        <a href="kelola_gudang.php" class="btn btn-primary">Daftar Gudang</a>
                    </div>                    
                    <form action="../../system/crud/gudang.php" method="post">                        
                        <input type="hidden" name="act" value="insert">
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
                                <div class="col-6">
                                    <div class="mb-2">
                                        <label for="nama_gudang">Nama Gudang</label>
                                        <input type="text" name="nama_gudang" class="form-control form-control-lg" id="nama_gudang" placeholder="Masukkan Nama Gudang" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-2">
                                        <label for="lokasi_gudang">Lokasi Gudang</label>
                                        <input type="text" name="lokasi_gudang" class="form-control form-control-lg" id="lokasi_gudang" placeholder="Masukkan Lokasi Gudang" required>
                                    </div>
                                </div>                                
                            </div> 
                        </div>                                            
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once '../layout/footer.php'; ?>