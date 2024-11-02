<?php
require_once '../../koneksi.php';


$sql = "SELECT jadwal_kelas.*,
        guru.nama_guru,
        guru.mata_pelajaran
        FROM jadwal_kelas
        JOIN guru ON guru.id_guru = jadwal_kelas.id_guru
";
$stmt = $conn->prepare($sql);
if(!$stmt->execute()) {
    echo "gagal mengambil data";
}

$result = $stmt->get_result();
?>

<?php require_once '../layout/header.php';?>

<section id="konten">
    <div class="container">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h4>Kelola Jadwal</h4>
                <a class="btn btn-primary" href="tambah_jadwal.php">Tambah jadwal</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kelas</td>                                                                
                                <td>Nama Guru</td>                                
                                <td>Jam Ke</td>                                
                                <td>Mata Pelajaran</td>                                
                                <td>Keterangan</td>                                
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i =1; ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i ?></td>                                
                                <td><?= $row['kelas'] ?></td>                                
                                <td><?= $row['nama_guru'] ?></td>                                
                                <td><?= $row['jam_ke'] ?></td>                                
                                <td><?= $row['mata_pelajaran'] ?></td>
                                <?php if($row['keterangan'] == '' || empty($row['keterangan'])) :?>
                                <td>-</td>
                                <?php else :?>
                                <td><?= $row['keterangan'] ?></td>
                                <?php endif;?>
                                <td>
                                    <a class="btn btn-primary" href="update_jadwal.php?id_jadwal=<?= $row['id_jadwal'] ?>">Edit</a>
                                    <a class="btn btn-danger" href="../../system/crud/jadwal.php?act=delete&id_jadwal=<?= $row['id_jadwal'] ?>">Hapus</a>
                                </td>
                            </tr>
                            <?php $i++;?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<?php require_once '../layout/footer.php';?>


