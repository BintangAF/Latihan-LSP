<?php
require_once '../../koneksi.php';

if(!isset($_GET['lokasi_gudang_lama']) || empty($_GET['lokasi_gudang_lama'])) {
    echo "lokasi gudang lama tidak boleh kosong";
    exit;
}

$lokasi_gudang_lama = $_GET['lokasi_gudang_lama'];

$stmt = $conn->prepare("SELECT * FROM gudang WHERE lokasi_gudang = ?");

$stmt->bind_param('s', $lokasi_gudang_lama);

if(!$stmt->execute()) {
    echo "gagal mengambil data";
    exit;
}

$result = $stmt->get_result();

$row = $result->fetch_assoc();

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
                        <h3>Form Update Gudang</h3>
                        <a href="kelola_gudang.php" class="btn btn-primary">Daftar Gudang</a>
                    </div>
                    <form action="../../system/crud/crud_gudang.php" method="post">
                    <div class="card-body">
                        <!-- <form action="" method="get">
                            <div class="col-12 input-group mb-3 w-25 float-end">
                                <input type="text" name="s" class="form-control" placeholder="Cari Nama Barang...">
                                <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            </div>                            
                        </form> -->
                        <div class="col-12">
                            
                            <input type="hidden" name="act" value="update">

                            <input type="hidden" name="lokasi_gudang_lama" value="<?= $lokasi_gudang_lama ?>">
                        
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label" for="namaGudang">Nama Gudang</label>
                                        <input type="text" class="form-control" name="nama_gudang" id="namaGudang" placeholder="Masukkan Nama Gudang" value="<?= $row['nama_gudang'] ?>" maxlength="30" required>

                                        <label class="form-label" for="lokasiGudang">Lokasi Gudang</label>
                                        <input type="text" class="form-control" name="lokasi_gudang_baru" id="lokasiGudang" placeholder="Masukkan Lokasi Gudang" value="<?= $row['lokasi_gudang'] ?>" maxlength="30" required>
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

<?php  require_once '../layout/footer.php';?>
