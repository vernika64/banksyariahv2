<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>

<body style="background:url('<?= base_url('addons/bg/login-wall.jpg') ?>'); background-size:cover;">
    <div class="container">
        <div class="row h-100">
            <div class="col-sm-12" style="margin-top: auto; margin-bottom:auto;">
                <div class="card" style="background-color: rgba(255,255,255,0.9);">
                    <div class="card-header">
                        Silahkan login untuk melanjutkan
                    </div>
                    <div class="card-body">
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
                        <?php
                        endif;
                        session()->destroy();
                        ?>
                        <form action="masuk" method="post">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" placeholder="Username" class="form-control" name="user">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" placeholder="Password" class="form-control" name="pass">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="login" class="btn btn-primary btn-block" value="Login">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</html>