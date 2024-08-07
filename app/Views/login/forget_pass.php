<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MDL | Lupa Password</title>

    <link rel="icon" href="<?= $this->ASSETS_URL ?>icon/logo.png">
    <script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!--  Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!--  IonIcons -->
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/ionicons.min.css">
    <!-- Font Awesome Icons -->
    <link href="<?= $this->ASSETS_URL ?>plugins/fontawesome-free-5.15.4-web/css/all.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/adminLTE-3.1.0/css/adminlte.min.css">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Titillium Web',
                sans-serif;
        }
    </style>
</head>

<body class="login-page" style="min-height: 496.781px;">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">MDL <b>Payment</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body register-card-body small">
                <p class="login-box-msg">Register a new membership</p>

                <!-- ALERT -->
                <div id="info"></div>

                <form id="form" action="<?= $this->BASE_URL ?>Register/ganti_password_99" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <label>Nomor Handphone</label>
                            <input type="text" class="form-control" name="no_user" placeholder="ID / No HP" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Reset Code</label>
                            <input type="text" class="form-control" id="reset_code" name="reset_code" placeholder="Reset Code" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password Baru" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Ulangi Password Baru</label>
                            <input type="password" class="form-control" id="repass" name="repass" placeholder="Retype password" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                Sudah ingat Password?<a href="<?= $this->BASE_URL ?>Login" class="text-center"> LOGIN</a>

                <div class="error"><span></span></div>
            </div>
            <!-- /.form-box -->
        </div>
    </div>

</body>

</html>