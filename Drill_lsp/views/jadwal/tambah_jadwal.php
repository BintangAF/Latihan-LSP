<?php
require_once '../../koneksi.php';

$stmt_kelas = $conn->prepare("SELECT kelas FROM kelas");
$stmt_guru = $conn->prepare("SELECT id_guru, nama_guru FROM guru");

if(!$stmt_kelas->execute()) {
    echo "gagal mengambil data kelas";
    exit;
}

$result_kelas = $stmt_kelas->get_result();
$stmt_kelas->close();

if(!$stmt_guru->execute()) {
    echo "gagal mengambil data guru";
    exit;
}

$result_guru = $stmt_guru->get_result();
$stmt_guru->close();

?>

<?php require_once '../layout/header.php';?>

<section id="konten">
    <div class="container">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h4>Tambah Jadwal</h4>
                <a class="btn btn-primary" href="kelola_jadwal.php">Daftar Jadwal</a>
            </div>
            <form action="../../system/crud/jadwal.php" method="post">
            <div class="card-body">
                <input type="hidden" name="act" value="insert">
                <div class="row">
                    <div class="col-6">
                        <!-- <div class="form-floating">
                            <input type="text" class="form-control" name="kelas" id="namajadwal" placeholder="Masukkan Nama jadwal" required>
                            <label for="namajadwal">Nama jadwal</label>
                        </div>                         -->
                        <label class="form-label">Kelas</label>
                        <select class="form-select" name="kelas" id="kelas">
                            <option value="">-- PILIH KELAS--</option>
                            <?php while($row_kelas = $result_kelas->fetch_assoc()) : ?>
                            <option value="<?= $row_kelas['kelas'] ?>"><?= $row_kelas['kelas'] ?></option>                                
                            <?php endwhile; ?>
                        </select>
                        <div class="form-floating">
                            <input type="number" class="form-control" name="jam_ke" id="jam_ke" min="1" max="15" placeholder="Masukkan Jam Pelajaran" required>
                            <label for="jam_ke">Jam Pelajaran</label>
                        </div>
                    </div>
                    <div class="col-6">                        
                        <label class="form-label">Guru</label>
                        <select class="form-select" name="id_guru" id="guru">
                            <option value="">-- PILIH GURU--</option>
                            <?php while($row_guru = $result_guru->fetch_assoc()) : ?>
                            <option value="<?= $row_guru['id_guru'] ?>"><?= $row_guru['nama_guru'] ?></option>                                
                            <?php endwhile; ?>
                        </select>                       
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


