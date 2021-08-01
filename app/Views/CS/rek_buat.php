<?= $this->extend('frame'); ?>

<?= $this->section('cpanel'); ?>

<?php
if (session()->getFlashdata('error')) :
?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
        <?php
        session()->unmarkFlashdata('error');
        ?>
    </div>
<?php
endif;
if (session()->getFlashdata('pesan')) :
?>
    <div class="alert alert-warning">
        <?= session()->getFlashdata('pesan'); ?>
        <?php
        session()->unmarkFlashdata('pesan');
        ?>
    </div>
<?php
endif;
?>
<?php if ($validation->listErrors() != NULL) : ?>
    <div class="alert alert-danger" role="alert">
        <h4>Rekening Tabungan tidak bisa dibuat</h4>
        <?= $validation->listErrors(); ?>
    </div>
<?php endif; ?>

<div class="white-box">
    <h1><?= $judul; ?></h1>
    <h4 style="margin-bottom:50px;">Pilih data nasabah yang akan membuat rekening tabungan</h4>

    <form action="registrasirek" method="post" style="display:inline;">
        <div class="row">
            <div class="col-2">
                <select class="form-select" name="tipe">
                    <option value="1">NIK</option>
                    <option value="2">Nama</option>
                </select>
            </div>
            <div class="col-9">
                <input type="text" class="form-control" placeholder="Cari" name="kd_cari">
            </div>
            <div class="col-1">
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-primary btn-block" value="Cari">
                </div>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <th>#</th>
            <th>NIK</th>
            <th>Nama Nasabah</th>
            <th>Alamat</th>
            <th>Tempat, Tgl Lahir</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php
            foreach ($nasabah as $n) :
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $n['kode_id']; ?></td>
                    <td><?= $n['nama_cif']; ?></td>
                    <td><?= $n['alamat_cif']; ?></td>
                    <td><?= $n['tempat_l']; ?>, <?= date("d-M-Y", strtotime($n['tgl_lhr_cif'])) ?></td>
                    <td>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#l<?= $n['kode_id']; ?>" role="button">Pilih</button>
                        <div class="modal fade" id="l<?= $n['kode_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Buat Rekening Tabungan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="prosesbuatrek" method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Nomor Antrian</label>
                                                <input type="hidden" value="<?= $n['kode_id']; ?>" name="kode">
                                                <input type="number" name="urut" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <select class="form-select" name="tabungan">
                                                    <?php
                                                    foreach ($tab as $z) :
                                                    ?>
                                                        <option value="<?= $z['kode_tabungan']; ?>"><?= $z['nama_produk']; ?></option>
                                                    <?php
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <input type="checkbox" class="form-check-input" name="TOS" id="TOS">
                                                <label class="form-check-label">Term of Service</label>
                                            </div>
                                            <div class="mb-3">
                                                <input type="checkbox" class="form-check-input" name="SK" id="SK">
                                                <label class="form-check-label">Syarat & Ketentuan</label>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-primary" onclick="return tombolval()">
                                            <script>
                                                function tombolval() {
                                                    var x = document.getElementById("TOS");
                                                    var y = document.getElementById("SK");

                                                    if (x.checked == true && y.checked == true) {
                                                        return true;
                                                    } else {
                                                        alert('ToS dan SK harus dicentang');
                                                        return false;
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $hal->links('cif', 'datatabel'); ?>

</div>

<?= $this->endSection(); ?>