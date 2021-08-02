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


    <div class="mb-3">
        <h3>Metode Pembayaran</h3>
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Tunai
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <form action="tr" method="post">
                            <div class="mb-3">
                                <label>No. Rekening Tujuan</label>
                                <input type="number" name="norek" class="form-control" style="-webkit-appearance: none;-moz-appearance: textfield;" placeholder="Masukkan nomor rekening tujuan">
                            </div>
                            <div class="mb-3">
                                <label>Pemilik Rekening</label>
                                <input type="text" name="an" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Nominal Transfer</label>
                                <input type="number" name="nominal" class="form-control" style="-webkit-appearance: none;-moz-appearance: textfield;" placeholder="Masukkan Nama pemilik rekening">
                            </div>
                            <div class="mb-3">
                                <label>Atas Nama</label>
                                <input type="text" name="tunai" class="form-control" placeholder="isi dengan huruf kapital">
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary btn-lg" name="btntun" value="Kirim">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Tabungan
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <form action="tr" method="post">
                            <div class="mb-3">
                                <label>No. Rekening Tujuan</label>
                                <input type="number" name="norek" class="form-control" style="-webkit-appearance: none;-moz-appearance: textfield;" placeholder="Masukkan nomor rekening tujuan">
                            </div>
                            <div class="mb-3">
                                <label>Pemilik Rekening</label>
                                <input type="text" name="an" class="form-control" placeholder="Masukkan Nama Penerima">
                            </div>
                            <div class="mb-3">
                                <label>Nominal Transfer</label>
                                <input type="number" name="nominal" class="form-control" style="-webkit-appearance: none;-moz-appearance: textfield;" placeholder="Masukkan Nama pemilik rekening">
                            </div>
                            <div class="mb-3">
                                <label>Nomor Rekening</label>
                                <input type="text" name="tab" class="form-control" placeholder="isi dengan nomor rekening pengirim yang sudah terdaftar">
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary btn-lg" name="btntab" value="Kirim">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?= $this->endSection(); ?>