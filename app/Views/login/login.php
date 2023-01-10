<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MDL PAYMENT</title>

    <link rel="icon" href="<?= $this->ASSETS_URL ?>icon/logo.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/bootstrap-4.6/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/ionicons.min.css">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/style.css">
    <link href="<?= $this->ASSETS_URL ?>plugins/fontawesome-free-5.15.4-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/adminLTE-3.1.0/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Titillium Web',
                sans-serif;
        }
    </style>


</head>

<body class="login-page small" style="min-height: 496.781px;">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">MDL | <b><span class="text-success">Payment</span></b></a><br>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login Session Baru</p>
                <div id="info"></div>
                <form action="<?= $this->BASE_URL ?>Login/cek_login" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="HP" class="form-control" placeholder="No. Handphone / ID" required autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span<i class="fas fa-mobile-alt"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="PASS" class="form-control" placeholder="Password" required autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <span id="span_loader" class="loader d-none"></span>
                            <button type="submit" id="btnSubmit" onclick="hide()" class="btn btn-success btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                <p class="mb-0">
                    <a href="<?= $this->BASE_URL ?>Register" class="text-center">Daftar Baru</a>
                    <a href="<?= $this->BASE_URL ?>Register/reset_pass" class="text-center text-info float-right">Lupa Password</a>
                </p>
                <hr>
                <p class="text-center">
                    MDL-Payment Support<br>081268098300 / 085278114125 (Whatsapp Only)
                </p>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function hide() {
        var element = document.getElementById("span_loader");
        element.classList.remove("d-none");

        document.getElementById('btnSubmit').style.visibility = 'hidden';
    }
</script>