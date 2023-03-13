<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MDL PAYMENT</title>

    <link rel="icon" href="<?= $this->ASSETS_URL ?>icon/logo.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/bootstrap-4.6/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/ionicons.min.css">
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

<body>
    <div class="text-center mt-4">
        Operation:
        <?= $data ?>
    </div>
    <div class="text-center mt-4">
        <button class="btn btn-lg btn-success" onclick="history.back()">Go Back</button>
    </div>
</body>