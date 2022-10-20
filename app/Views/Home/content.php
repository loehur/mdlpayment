<?php
$topup_success = array();
$topup_proses_count = 0;
foreach ($data['topup'] as $a) {
    switch ($a['topup_status']) {
        case 2:
            array_push($topup_success, $a['jumlah']);
            break;
        case 1:
            $topup_proses_count += 1;
            break;
    }
}

$saldo = array_sum($topup_success);

$trx_success = array();
foreach ($data['callback'] as $a) {
    if ($a['rc'] == "00" || $a['rc'] == "39" || $a['rc'] == "201") {
        array_push($trx_success, $a['price_sell']);
    }
}
$saldo_trx_success = array_sum($trx_success);

$saldo = $saldo - $saldo_trx_success;

?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                Outlate/Staff
                <h6><b class="text-success"><?= $this->userData['nama'] ?></b></h6>
            </div>
            <div class="col-auto">
                <span class="float-right">Saldo</span><br>
                <h6><b class="text-success"><?= number_format($saldo) ?></b></h6>
            </div>
        </div>
    </div>
</div>
<hr>

<?php if ($topup_proses_count > 0) { ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto mr-auto">
                    Setoran Dalam Proses
                </div>
            </div>
        </div>
    </div>
    <hr>
<?php } ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                5 Transaksi Terakhir
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>