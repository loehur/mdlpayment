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

<body class="login-page" style="min-height: 496.781px;">
    <div class="login-box">
        <div class="card">
            <div class="card-body register-card-body small">
                <!-- ALERT -->
                <div id="info"></div>
                <form id="form" action="<?= $this->BASE_URL ?>Enc/enc_post" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="id" placeholder="id" required></input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control" name="lock" placeholder="lock" required>
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
        <div class="card">
            <div class="card-body register-card-body small">
                <!-- ALERT -->
                <div id="info"></div>
                <form id="form" action="<?= $this->BASE_URL ?>Reset/pass_post" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="id" placeholder="id" required></input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="code" placeholder="code" required></input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control" name="lock" placeholder="lock" required>
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
        <div class="card">
            <div class="card-body register-card-body small">
                <!-- ALERT -->
                <div id="info"></div>
                <form id="form" action="<?= $this->BASE_URL ?>Reset/pin_post" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="id" placeholder="id" required></input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="code" placeholder="code" required></input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control" name="lock" placeholder="lock" required>
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

</body>

</html>