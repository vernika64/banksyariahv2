<?= $this->extend('frame'); ?>

<?= $this->section('cpanel'); ?>
<div class="white-box">
    <h1><?= $judul; ?></h1>

    <form action="" method="post" style="margin-top: 20px;">
        <div class="mb-3">
            <label>Pilih jenis peminjam</label>
            <select class="form-select" name="tipepeminjamn">
                <option selected>-- Pilih --</option>
                <option value="perorangan">Perorangan</option>
                <!-- <option value="bisnis">Bisnis</option> -->
            </select>
        </div>
        <div class="mb-3">
            <label>Pilih data nasabah</label>
            <select class="form-select" name="cif">
                <option selected>-- Pilih CIF --</option>
                <?php
                $no1 = 1;
                foreach ($listcif as $o) :

                ?>
                    <option value="<?= $no1++ ?>"><?= $o['kode_id'] . " - " . $o['nama_cif'] ?></option>
                <?php
                endforeach;
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah pinjaman yang diinginkan</label>
            <input type="number" class="form-control" name="nominal" placeholder="Isikan sesuai kebutuhan peminjam">
        </div>
        <div class="mb-3">
            <label>Alasan Peminjaman</label>
            <textarea class="form-control" rows="4" name="alasan"></textarea>
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="pelengkap" name="dokumen">
                <label class="form-check-label" for="pelengkap">Dokumen Pelengkap</label>
            </div>
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary btn-lg" value="Daftar">
        </div>
    </form>
</div>

<?= $this->endSection(); ?>