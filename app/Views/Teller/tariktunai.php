<?= $this->extend('frame'); ?>

<?= $this->section('cpanel'); ?>

<?php
if (session()->getFlashdata('pesan')) :
?>
    <div class="alert alert-warning">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
<?php
endif;
?>
<?php
if (session()->getFlashdata('error')) :
?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php
endif;
?>

<div class="white-box">
    <h1><?= $judul; ?></h1>
    <form action="tt" method="post">
        <div class="row" style="margin-top: 40px;">
            <div class="col-11">
                <div class="input-group mb-3">
                    <span class="input-group-text">No. Rekening Tabungan</span>
                    <input type="text" class="form-control" placeholder="Cari" name="kd_cari">
                </div>
            </div>
            <div class="col-1">
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-primary btn-block" value="Cari">
                </div>
            </div>
        </div>
    </form>
    <table class="table table-hover">
        <thead>
            <th>#</th>
            <th>No. Rekening</th>
            <th>Nama Nasabah</th>
            <th>Jenis Tabungan</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php foreach ($tabungan as $tb) : ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $tb['norek']; ?></td>
                    <td><?= $tb['nama_cif']; ?></td>
                    <td><?= $tb['nama_produk']; ?></td>
                    <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#s<?= $no; ?>" aria-expanded="false">Pilih</button></td>
                    <div class="modal fade" id="s<?= $no++; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="ptt" method="post">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Nominal Uang</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rp. </span>
                                                <input type="hidden" name="kode" class="form-control" value="<?= $tb['tab_uid']; ?>">
                                                <input type="text" class="form-control" placeholder="Cari" name="jmltarik">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" value="Tarik" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>


<?= $this->endSection(); ?>