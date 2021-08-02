<?= $this->extend('frame'); ?>

<?= $this->section('cpanel'); ?>

<div class="white-box">
    <h1><?= $judul; ?></h1>

    <form action="tutuprekening" method="post" style="margin-top: 50px;">
        <div class="row">
            <div class="col-10">
                <input type="text" name="cari" class="form-control" placeholder="Masukkan nomor rekening tabungan nasabah">
            </div>
            <div class="col-2">
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-primary btn-block" value="Cari">
                </div>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <h1>Hasil Pencarian</h1>
        <table class="table table-hover">
            <thead>
                <th>#</th>
                <th>Nomor Rekening</th>
                <th>Nama Nasabah</th>
                <th>Jenis Tabungan</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                <!-- <tr>
                    <td></td>
                </tr> -->
            </tbody>
        </table>
    </div>
</div>


<?= $this->endSection(); ?>