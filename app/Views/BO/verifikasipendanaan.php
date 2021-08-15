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

    <table class="table table-hover">
        <thead>
            <th>#</th>
            <th>No. Nota</th>
            <th>Nasabah</th>
            <th>Jenis Pendanaan</th>
            <th>Nama Barang</th>
            <th>Total Pendanaan</th>
            <th>Status</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php
            foreach ($list as $z) :
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $z['no_nota']; ?></td>
                    <td><?= $z['nama_cif']; ?></td>
                    <td>
                        <?php
                        switch ($z['jenis']) {
                            case 1:
                                echo "Komputer";
                                break;
                            case 2:
                                echo "Telekomunikasi";
                                break;
                            case 3:
                                echo "Transportasi";
                                break;
                            case 4:
                                echo "Lain-lain";
                                break;
                        }
                        ?></td>
                    <td><?= $z['barang']; ?></td>
                    <td><?php
                        $s = $z['satuan'] * $z['qty'];
                        echo "Rp. " . number_format($s, 2, ".", ",");
                        ?></td>
                    <td>
                        <?php
                        switch ($z['status']) {
                            case 0:
                        ?>
                                <span class="badge bg-secondary">Menunggu Verifikasi</span>
                            <?php
                                break;
                            case 1:
                            ?>
                                <span class="badge bg-primary">Sudah Verifikasi</span>
                            <?php
                                break;
                            case 2:
                            ?>
                                <span class="badge bg-warning">Menunggu Acc SPV</span>
                            <?php
                                break;
                            case 3:
                            ?>
                                <span class="badge bg-info">Nasabah Tidak Jadi</span>
                            <?php
                                break;
                            case 4:
                            ?>
                                <span class="badge bg-danger">Ditolak</span>
                            <?php
                                break;
                            case 5:
                            ?>
                                <span class="badge bg-danger">Proses Pembayaran</span>
                            <?php
                                break;
                            case 6:
                            ?>
                                <span class="badge bg-danger">Selesai</span>
                            <?php
                                break;
                            case 7:
                            ?>
                                <span class="badge bg-danger">Gagal Bayar</span>
                        <?php
                                break;
                        }
                        ?>
                        </span>
                    </td>
                    <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#muncul-<?= $no; ?>">Detail</button></td>
                    <div class="modal fade" id="muncul-<?= $no++; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Detail Pendanaan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="verifpendaok" method="post">
                                    <input type="hidden" name="nota" value="<?= $z['uid']; ?>">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <input type="text" value="<?= $z['kode_id']; ?>" class="form-control bg-white" disabled>
                                                <label>NIK</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <input type="text" value="<?= $z['nama_cif']; ?>" class="form-control bg-white" disabled>
                                                <label>Nama Nasabah</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <input type="text" value="<?= $z['alamat_cif']; ?>" class="form-control bg-white" disabled>
                                                <label>Alamat Nasabah</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <input type="text" value="<?= $z['barang']; ?>" class="form-control bg-white" disabled>
                                                <label>Nama Barang</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <input type="text" value="<?= "Rp. " . number_format($z['satuan'], 2, ".", ","); ?>" class="form-control bg-white" disabled>
                                                <label>Harga Satuan</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <input type="text" value="<?= $z['qty']; ?>" class="form-control bg-white" disabled>
                                                <label>Qty</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <input type="text" value="Rp. <?= number_format($z['qty'] * $z['satuan'], 2, ".", ","); ?>" class="form-control bg-white" style="font-weight:bold;" disabled>
                                                <label>Total</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <textarea class="form-control bg-white" style="height: 100px;" disabled><?= $z['alasan']; ?></textarea>
                                                <label>Alasan pendanaan</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <?php
                                                $s = $z['pembayaran'];
                                                if ($s == "tunai") {
                                                    $i = "Tunai";
                                                } else if ($s == "kredit") {
                                                    $i = "Kredit";
                                                }
                                                ?>
                                                <input type="text" class="form-control bg-white" value="<?= $i; ?>" disabled>
                                                <label>Metode Pembayaran</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Tutup</button>
                                        <input type="submit" name="lanjut" value="Verifikasi" class="btn btn-primary">
                                        <input type="submit" name="lanjut" value="Tolak" class="btn btn-danger text-white">
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