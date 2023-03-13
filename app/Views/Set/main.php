<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MDL | Set</title>
    <link rel="icon" href="<?= $this->ASSETS_URL ?>icon/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/ionicons.min.css">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/fontawesome-free-5.15.4-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/bootstrap-4.6/bootstrap.min.css">
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

<body style="max-width: 752px; min-width:  <?= $min_width ?>;" class="m-auto small border border-bottom-0 pt-5 pr-1 pl-1">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body register-card-body small bg-light">
                <b><?php print_r($data) ?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body register-card-body small">
                        <!-- ALERT -->
                        <div id="info">VERIFY</div>
                        <form id="form" action="<?= $this->BASE_URL ?>Enc/enc_post" method="post">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="id" placeholder="id" required></input>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lock" placeholder="lock" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body register-card-body small">
                        <!-- ALERT -->
                        <div id="info">PASSWORD</div>
                        <form id="form" action="<?= $this->BASE_URL ?>Reset/pass_post" method="post">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="id" placeholder="id" required></input>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="code" placeholder="code" required></input>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lock" placeholder="lock" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body register-card-body small">
                        <!-- ALERT -->
                        <div id="info">PIN</div>
                        <form id="form" action="<?= $this->BASE_URL ?>Reset/pin_post" method="post">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="id" placeholder="id" required></input>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="code" placeholder="code" required></input>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lock" placeholder="lock" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body register-card-body small">
                        <!-- ALERT -->
                        <div id="info">ENC</div>
                        <form id="form" action="<?= $this->BASE_URL ?>Enc/enc_form" method="post">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="text" placeholder="text" required></input>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lock" placeholder="lock" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body register-card-body small">
                        <!-- ALERT -->
                        <div id="info">ENC_2</div>
                        <form id="form" action="<?= $this->BASE_URL ?>Enc/enc_form_2" method="post">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="text" placeholder="text" required></input>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lock" placeholder="lock" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>