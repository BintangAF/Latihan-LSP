<?php require_once '../layout/header.php';?>

<section id="konten">
    <div class="container">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h4>Tambah Kelas</h4>
                <a class="btn btn-primary" href="kelola_kelas.php">Daftar kelas</a>
            </div>
            <form action="../../system/crud/kelas.php" method="post">
            <div class="card-body">
                <input type="hidden" name="act" value="insert">
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="jenjang" id="jenjang" step="1" min="10" max="12" placeholder="Masukkan Jenjang Kelas" required>
                            <label for="jenjang">Jenjang Kelas</label>
                        </div>                        
                    </div>
                    <div class="col-6">                        
                        <div class="form-floating">
                            <input type="text" class="form-control" name="konsentrasi_keahlian" id="konsentrasiKeahlian" placeholder="Masukkan Konsentrasi Keahlian" required>
                            <label for="konsentrasiKeahlian">Masukkan Konsentrasi Keahlian</label>
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


