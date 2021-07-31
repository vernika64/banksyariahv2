<?= $this->extend('frame'); ?>

<?= $this->section('cpanel'); ?>
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
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel list CIF -->

    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>No. Rek</th>
                <th>Nama Customer</th>
                <th>Tempat Lahir</th>
                <th>JK</th>
                <th>Aksi</th>
            </tr>
        </thead>

    </table>
</div>
<?= $this->endSection(); ?>