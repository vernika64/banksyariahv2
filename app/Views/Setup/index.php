<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perbankan Syariah | Selamat Datang</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <style>
        .btn-setup {
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 0px !important;
            font-weight: lighter;
        }

        h1 {
            font-weight: lighter;
        }

        i {
            color: #FFF;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body style="background-color: #242582;">
    <div class="container" id="welcome">
        <div class="row h-100">
            <div class="col-sm-12" style="margin-top: auto; margin-bottom:auto;">
                <div class="card">
                    <div class="card-body">
                        <h1>Selamat Datang di Sistem Perbankan Syariah</h1>
                        <p>Silahkan klik lanjut untuk memulai penyetelan sistem website</p>
                        <a class="btn btn-primary btn-lg btn-setup" id="kedaftar" href="#daftar">Lanjut <i class="icon-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="daftar">
        <div class="row h-100">
            <div class="col-sm-12" style="margin-top: auto; margin-bottom:auto;">
                <div class="card">
                    <div class="card-header">
                        <h3>Registrasi Pembukaan Cabang Baru</h3>
                    </div>
                    <div class="card-body">
                        <form action="daftarbank" method="post">
                            <h4>Informasi Dasar Bank</h4>
                            <div class="form-group">
                                <label>Kode Bank</label>
                                <input type="number" name="kode_bk" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Cabang Bank</label>
                                <input type="text" name="nama_bk" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Alamat Bank</label>
                                <textarea name="alamat_bk" class="form-control"></textarea>
                            </div>
                            <br>
                            <hr>
                            <br>
                            <h4>Informasi Kepala Cabang</h4>
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="number" name="kode_kc" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Kepala Cabang</label>
                                <input type="text" name="nama_kc" class="form-control" placeholder="Nama sesuai dengan kartu identitas">
                            </div>
                            <div class="form-group">
                                <label>Alamat Rumah</label>
                                <textarea name="alamat_kc" class="form-control" placeholder="Alamat sesuai dengan kartu identitas"></textarea>
                            </div>
                            <div class="form-group">
                                <label>No Ponsel</label>
                                <input type="number" name="np_kc" class="form-control" placeholder="Contoh : 081233233233">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email_kc" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="pass_kc1" class="form-control" placeholder="Password minimal harus 8 karakter" id="pw1">
                                <input type="password" class="form-control" placeholder="Ulangi password diatas" style="margin-top: 10px;" id="pw2">
                                <div id="fpass" style="color: green;"></div>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="simpan" class="btn btn-primary btn-block" value="Simpan">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<script>
    function checkPasswordMatch() {
        var password1 = $("#pw1").val();
        var password2 = $("#pw2").val();
        if (password1 != password2)
            $("#fpass").html("Password tidak sama");
        else
            $("#fpass").html("Password sama");
    }

    $(document).ready(function() {
        $("#pw2").keyup(checkPasswordMatch);
    });
</script>

<script>
    $("#kedaftar").click(function() {
        $('html, body').animate({
            scrollTop: $("#daftar").offset().top
        }, 1000, function() {
            $('#welcome').remove();
        });
    });
</script>

</html>