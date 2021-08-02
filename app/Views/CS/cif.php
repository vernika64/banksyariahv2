<?= $this->extend('frame'); ?>

<?= $this->section('cpanel'); ?>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-warning">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<?= $validation->listErrors(); ?>
<div class="white-box">
    <h1><?= $judul; ?></h1>

    <button class="btn btn-primary" style="margin-bottom: 30px;" data-bs-toggle="modal" data-bs-target="#buatcif">Registrasi CIF Baru</button>

    <!-- Kotak Daftar -->

    <div class="modal fade" tabindex="-1" id="buatcif">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-kotak">
                <div class="modal-header">
                    <h5 class="modal-title">Form Registrasi CIF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="procif" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="number" name="kode" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama sesuai identitas</label>
                            <input type="text" name="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-auto">
                                    <label>Kota Lahir</label>
                                    <input type="text" name="tl" class="form-control">
                                </div>
                                <div class="col-auto">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tr" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat sesuai Identitas</label>
                            <textarea name="alamat_s" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jk" class="form-control">
                                <option value="m">Laki - Laki</option>
                                <option value="f">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Warganegara</label>
                            <select name="wn" class="form-control">
                                <option value="1">WNI</option>
                                <option value="2">WNA</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status Nikah</label>
                            <select name="sn" class="form-control">
                                <option value="1">Belum</option>
                                <option value="2">Sudah</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel list CIF -->

    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>NIK</th>
                <th>Nama Customer</th>
                <th>Alamat</th>
                <th>Tempat, Tgl Lahir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listcif as $l) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $l['kode_id']; ?></td>
                    <td><?= $l['nama_cif']; ?></td>
                    <td><?= $l['alamat_cif']; ?></td>
                    <td><?= $l['tempat_l']; ?>, <?= date("d-M-Y", strtotime($l['tgl_lhr_cif'])); ?></td>
                    <td>
                        <button class="btn btn-primary">Details</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $hal->links('cif', 'datatabel'); ?>
</div>
<?= $this->endSection(); ?>