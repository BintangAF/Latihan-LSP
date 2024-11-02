<?php
require_once '../../koneksi.php';

$stmt = $conn->prepare("SELECT * FROM kelas");

if(!$stmt->execute()) {
    echo "Gagal mengambil data";
    exit;
}

$result = $stmt->get_result();

?>

<?php require_once '../layout/header.php';?>

<section id="konten">
    <div class="container">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h4>Kelola Kelas</h4>
                <a class="btn btn-primary" href="tambah_kelas.php">Tambah Kelas</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Jenjang</td>                                                                
                                <td>Konsetrasi Keahlian</td>                                
                                <td>Kelas</td>                                
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;  ?>
                            
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i ?></td>                                
                                <td><?= $row['jenjang'] ?></td>                                
                                <td><?= $row['konsentrasi_keahlian'] ?></td>
                                <td><?= $row['kelas'] ?></td>
                                <td>
                                    <a class="btn btn-primary" href="update_kelas.php?kelas=<?= $row['kelas'] ?>">Edit</a>
                                    <a class="btn btn-danger" href="../../system/crud/kelas.php?act=delete&kelas=<?= $row['kelas'] ?>" onclick="return confirm('Anda Yakin?');">Hapus</a>
                                </td>
                            </tr>
                            <?php $i++;  ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<?php require_once '../layout/footer.php';?>


