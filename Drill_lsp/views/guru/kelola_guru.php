<?php
require_once '../../koneksi.php';

$stmt = $conn->prepare("SELECT * FROM guru");

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
                <h4>Kelola Guru</h4>
                <a class="btn btn-primary" href="tambah_guru.php">Tambah Guru</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Guru</td>                                                                
                                <td>Mata Pelajaran</td>                                
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php while($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $i ?></td>                                
                                <td><?= $row['nama_guru'] ?></td>                                
                                <td><?= $row['mata_pelajaran'] ?></td>
                                <td>
                                    <a class="btn btn-primary" href="update_guru.php?id_guru=<?= $row['id_guru'] ?>">Edit</a>
                                    <a class="btn btn-danger" href="../../system/crud/guru.php?act=delete&id_guru=<?= $row['id_guru'] ?>" onclick="return confirm('Anda Yakin?');">Hapus</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<?php require_once '../layout/footer.php';?>


