<?php require_once '../layout/header.php';?>

<section id="konten">
    <div class="container">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h4>Tambah Guru</h4>
                <a class="btn btn-primary" href="kelola_guru.php">Daftar Guru</a>
            </div>
            <form action="../../system/crud/guru.php" method="post">
            <div class="card-body">
                <input type="hidden" name="act" value="insert">
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="nama_guru" id="namaGuru" placeholder="Masukkan Nama Guru" required>
                            <label for="namaGuru">Nama Guru</label>
                        </div>                        
                    </div>
                    <div class="col-6">                        
                        <div class="form-floating">
                            <input type="text" class="form-control" name="mata_pelajaran" id="mapel" placeholder="Masukkan Mata Pelajaran" required>
                            <label for="mapel">Mata Pelajaran</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Kirim</button>
            </div>
            </form>
        </div>
    </div>
</section>


<?php require_once '../layout/footer.php';?>


