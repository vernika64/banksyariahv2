<?= $this->extend('frame'); ?>

<?= $this->section('cpanel'); ?>

<?php
if (session()->getFlashdata('error')) :
?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php
endif;
if (session()->getFlashdata('pesan')) :
?>
    <div class="alert alert-warning">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
<?php endif; ?>


<div class="white-box">
    <h1><?= $judul; ?></h1>

    <h4 style="margin-top: 20px;">List Akun Tabungan yang belum diverifikasi</h4>
    <table class="table table-hover">
        <thead>
            <th>#</th>
            <th>Nomor Rekening</th>
            <th>Nama Pengaju</th>
            <th>Tipe Tabungan</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php
            foreach ($tabungan as $m) :
            ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $m['norek']; ?></td>
                    <td><?= $m['nama_cif']; ?></td>
                    <td><?= $m['nama_produk']; ?></td>
                    <td>
                        <form action="veriftabok" method="post">
                            <input type="hidden" name="kode" value="<?= $m['tab_uid']; ?>">
                            <input type="submit" name="kirim" class="btn btn-primary" value="Terima" onclick="return confirm('Apakah anda yakin untuk menerima verifikasi tabungan ini ?');">
                            <input type="submit" name="kirim" class="btn btn-danger text-white" value="Tolak" onclick="return confirm('Apakah anda yakin untuk menolak verifikasi tabungan ini ?');">
                        </form>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>