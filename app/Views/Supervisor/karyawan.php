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
<?php if ($validation->listErrors() != NULL) : ?>
    <div class="alert alert-danger" role="alert">
        <h4>Karyawan tidak bisa ditambahkan</h4>
        <?= $validation->listErrors(); ?>
    </div>
<?php endif; ?>
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
                            <label class="form-label">Nomor NIK</label>
                            <input type="number" class="form-control" name="kode">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama sesuai KTP</label>
                            <input type="text" class="form-control" name="nama">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat sesuai KTP</label>
                            <textarea rows="3" class="form-control" name="alamat"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Ponsel</label>
                            <input type="number" class="form-control" name="ponsel">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-Mail</label>
                            <input type="email" class="form-control" name="email">
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
                                    echo "Kepala Cabang";
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
                                case 4:
                                    echo "Back Office";
                                    break;
                            }

                            ?>
                        </td>
                        <td><?= $m['email']; ?></td>
                        <td>
                            <?php
                            if ($m['level'] != 0) :
                            ?>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><button class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#d<?= $m['nik']; ?>">Update Data</button></li>
                                            <li><button class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#d<?= $m['nik']; ?>">Ubah Password</button></li>
                                            <li><a class="dropdown-item" href="#">Hapus</a></li>

                                </div>
                            <?php
                            endif;
                            ?>
                            <div class="modal fade" id="d<?= $m['nik']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="nik" class="form-label">Nomor NIK</label>
                                                    <input type="number" class="form-control" id="nik" name="kode" readonly value="<?= $m['nik']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama sesuai KTP</label>
                                                    <input type="text" class="form-control" id="name" name="nama" value="<?= $m['nama']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat sesuai KTP</label>
                                                    <textarea rows="3" class="form-control" id="alamat" name="alamat"><?= $m['alamat_ktp']; ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomorp" class="form-label">Nomor Ponsel</label>
                                                    <input type="number" class="form-control" id="nomorp" name="ponsel" value="<?= $m['no_telp']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">E-Mail</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="<?= $m['email']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jabatan" class="form-label">Jabatan</label>
                                                    <select class="form-control" id="jabatan" name="jabatan">
                                                        <?php
                                                        switch ($m['level']) {
                                                            case 0:
                                                        ?>
                                                                <option value="0" selected>Kepala Cabang</option>
                                                            <?php
                                                                break;
                                                            case 1:
                                                            ?>
                                                                <option value="1" selected>Supervisor</option>
                                                                <option value="2">Customer Service</option>
                                                                <option value="3">Teller</option>
                                                                <option value="4">Back Office</option>
                                                            <?php
                                                                break;
                                                            case 2:
                                                            ?>
                                                                <option value="1">Supervisor</option>
                                                                <option value="2" selected>Customer Service</option>
                                                                <option value="3">Teller</option>
                                                                <option value="4">Back Office</option>
                                                            <?php
                                                                break;
                                                            case 3:
                                                            ?>
                                                                <option value="1">Supervisor</option>
                                                                <option value="2">Customer Service</option>
                                                                <option value="3" selected>Teller</option>
                                                                <option value="4">Back Office</option>
                                                            <?php
                                                                break;
                                                            case 4:
                                                            ?>
                                                                <option value="1">Supervisor</option>
                                                                <option value="2">Customer Service</option>
                                                                <option value="3">Teller</option>
                                                                <option value="4" selected>Back Office</option>
                                                        <?php
                                                                break;
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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