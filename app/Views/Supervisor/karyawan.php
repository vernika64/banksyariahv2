<?= $this->extend('frame'); ?>

<?= $this->section('cpanel'); ?>

<?php

if (session()->getFlashdata('pesan') != NULL) :

?>
    <div class="alert alert-warning" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
    </div>

<?php
endif;
if (session()->getFlashdata('error') != NULL) :
?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php
endif;
?>
<?php // if ($validation->listErrors()) : 
?>
<!-- <div class="alert alert-danger" role="alert">
        <h4>Karyawan tidak bisa ditambahkan</h4> -->
<?php // $validation->listErrors(); 
?>
<!-- </div> -->
<?php // endif; 
?>
<div class="white-box">
    <h1><?= $judul; ?></h1>

    <button class="btn btn-primary" style="margin-bottom: 30px;" data-bs-toggle="modal" data-bs-target="#buatkaryawan">Registrasi Karyawan Baru</button>

    <!-- Kotak Daftar -->

    <div class="modal fade" tabindex="-1" id="buatkaryawan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-kotak">
                <div class="modal-header">
                    <h5 class="modal-title">Form Registrasi Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="dafkar" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nik" class="form-label">Nomor NIK</label>
                            <input type="number" class="form-control" id="nik" name="kode">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama sesuai KTP</label>
                            <input type="text" class="form-control" id="name" name="nama">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat sesuai KTP</label>
                            <textarea rows="3" class="form-control" id="alamat" name="alamat"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="nomorp" class="form-label">Nomor Ponsel</label>
                            <input type="number" class="form-control" id="nomorp" name="ponsel">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <select class="form-control" id="jabatan" name="jabatan">
                                <option value="1">Supervisor</option>
                                <option value="2">Customer Service</option>
                                <option value="3">Teller</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" class="form-control" id="nik" name="pass" placeholder="Masukkan password minimal 8 huruf" style="margin-bottom: 10px;">
                            <input type="password" class="form-control" id="nik" name="pass2" placeholder="Ulangi password">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
                <th>Nama Karyawan</th>
                <th>Posisi</th>
                <th>email</th>
                <th>Aksi</th>
            </tr>

        </thead>
        <tbody>
            <?php

            foreach ($karya as $m) :

            ?>
                <tr>
                    <?php if ($m['deleted_at'] == NULL) : ?>
                        <td><?= $no++; ?></td>
                        <td><?= $m['nik']; ?></td>
                        <td><?= $m['nama']; ?></td>
                        <td>
                            <?php
                            switch ($m['level']) {
                                case 0:
                                    echo "Administrator";
                                    break;
                                case 1:
                                    echo "Supervisor";
                                    break;
                                case 2:
                                    echo "Customer Service";
                                    break;
                                case 3:
                                    echo "Teller";
                                    break;
                                default:
                                    echo "No Identity";
                            }

                            ?>
                        </td>
                        <td><?= $m['email']; ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-primary">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Edit Data</a></li>
                                        <li><a class="dropdown-item" href="#">Hapus</a></li>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
    <?= $hal->links('karyawan', 'datatabel'); ?>
</div>
</div>

<?= $this->endSection(); ?>