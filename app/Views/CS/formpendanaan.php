<?= $this->extend('frame'); ?>

<?= $this->section('cpanel'); ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-warning">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
<?php endif; ?>


<div class="white-box">
    <h1><?= $judul; ?></h1>
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-4">
            <div class="d-grid">
                <button class="btn btn-primary btn-lg" data-bs-toggle="collapse" data-bs-target="#tambah">
                    <i class="fas fa-plus"></i>
                    &nbsp;Buat Kontrak Baru
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-grid">
                <button class="btn btn-warning btn-lg" data-bs-toggle="collapse" data-bs-target="#cari-list">
                    <i class="fas fa-search"></i>
                    &nbsp;Status Kontrak
                </button>
            </div>
        </div>

    </div>
</div>

<div class="card collapse" id="cari-list">
    <div class="card-body">
        <h4>Cari Kontrak</h4>
        <form>
            <div class="row" style="margin-top: 20px;">
                <div class="col-11">
                    <input type="text" name="cari" class="form-control" placeholder="Cari berdasarkan Nomor Nota Kontrak">
                </div>
                <div class="col-1">
                    <div class="d-grid">
                        <input type="submit" class="btn btn-primary" value="Cari">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="card collapse" id="tambah">
    <div class="card-body">
        <h3 style="margin-bottom: 20px;">Form Registrasi Kontrak</h3>
        <form action="buatkontrakpen" method="post" style="margin-top:10px;">
            <div class="mb-3">
                <label>Nama Nasabah</label>
                <select name="nasabah" class="form-select">
                    <option value="">-- Pilih Nasabah --</option>
                    <?php foreach ($list as $z) : ?>
                        <option value="<?= $z['uid']; ?>" data-bs-toggle="collapse" data-bs-target="#tambah"><?= $z['kode_id']; ?> - <?= $z['nama_cif']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Pendanaan</label>
                <select class="form-select" name="jenis">
                    <option value="1">Komputer</option>
                    <option value="2">Telekomunikasi</option>
                    <option value="3">Transportasi</option>
                    <option value="4">Lain - Lain</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Barang yang diminta</label>
                <input type="text" name="barang" class="form-control" placeholder="Nama barang">
            </div>
            <div class="mb-3">
                <div class="row">
                    <label class="form-label">Harga satuan dan Kuantias barang</label>
                    <div class="col-11">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="rupiah">Rp.</span>
                            <input type="number" class="form-control" name="harga" placeholder="" aria-labelledby="rupiah" aria-label="Harga Satuan">
                        </div>
                    </div>
                    <div class="col-1">
                        <input type="number" name="qty" class="form-control" placeholder="Qty">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Alasan Pendanaan</label>
                <textarea name="alasan" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label>Metode Pembayaran</label>
                <div class="form-check form-switch">
                    <input type="radio" class="form-check-input" id="metode1" name="tipem" value="tunai">
                    <label for="metode1" class="form-check-label">Tunai</label>
                </div>
                <div class="form-check form-switch">
                    <input type="radio" class="form-check-input" id="metode2" name="tipem" value="kredit">
                    <label for="metode2" class="form-check-label">Kredit</label>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="pendukung" class="form-check-input" id="clue1">
                    <label class="form-check-label" for="clue1">File Pendukung</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="sk" class="form-check-input" id="sk">
                    <label class="form-check-label" for="sk">Syarat & Ketentuan</label>
                </div>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary btn-lg" value="Ajukan">
            </div>
        </form>
    </div>
</div>


<div class="card collapse" id="selesai">
    <div class="card-body">
        <h4>Hapus</h4>
    </div>
</div>

<div class="card collapse">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <th>#</th>
                <th>No. Kontrak</th>
                <th>Judul Kontrak</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script>
    function cek() {
        var x = document.getElementById('clue1');
        var y = document.getElementById('sk');

        if (x.checked == true && y.checked == true) {
            return true;
        } else {
            alert('Syarat dan SK harus dilengkapi');
            return false;
        }
    }
</script>
<?= $this->endSection(); ?>