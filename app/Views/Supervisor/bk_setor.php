<?= $this->extend('frame'); ?>

<?= $this->section('cpanel'); ?>

<div class="white-box">
    <h1><?= $judul; ?></h1>

    <table class="table table-hover">
        <thead>
            <th>#</th>
            <th>No. Transaksi</th>
            <th>No. Rekening Tujuan</th>
            <th>Atasnama</th>
            <th>Nominal</th>
            <th>Pengirim</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php foreach ($bk_transfer as $l) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $l['no_nota']; ?></td>
                    <td><?= $l['no_rek_tujuan']; ?></td>
                    <td><?= $l['atasnama']; ?></td>
                    <td><?= $l['num_transfer']; ?></td>
                    <td><?= $l['nama_pengirim']; ?></td>
                    <td><button class="btn btn-primary">Details</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $pager->links('bk_transfer', 'datatabel'); ?>
</div>


<?= $this->endSection(); ?>