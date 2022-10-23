<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                Outlate/Staff
                <h6><b class="text-success"><?= ($this->userData['nama'] == $this->setting['nama']) ? $this->setting['nama'] : $this->setting['nama'] . "/" . $this->userData['nama']; ?></b></h6>
            </div>
            <div class="col-auto">
                <span class="float-right">Kas</span><br>
                <h6><b class="text-success"><?= number_format($data['kas']) ?></b></h6>
            </div>
            <div class="col-auto">
                <span class="float-right">Saldo</span><br>
                <h6><b class="text-success"><?= number_format($data['saldo']) ?></b></h6>
            </div>
        </div>
    </div>
</div>
<hr>
<span class="ml-3"><b>PRA BAYAR</b></span>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <?php
            $no = 0;
            $antri_pre_count = 0;
            $proses_pre_count = 0;
            foreach ($data['data_pre'] as $a) {
                $no++;
                if ($no > 5) {
                    break;
                }
                if (($a['tr_status'] == 0) && strlen($a['rc']) == 0) {
                    $antri_pre_count += 1;
                }
                if ($a['rc'] == "39" || $a['rc'] == "201") {
                    $proses_pre_count += 1;
                }
            ?>
                <div class="col-md-12 border pb-1">
                    <table class="table table-borderless table-sm mb-0 pb-0">
                        <tr>
                            <td><small>#<?= $a['tr_id'] ?><br><?= $a['no_user'] ?></small></td>
                            <td><?= $a['customer_id'] ?><br><small><?= $a['description'] ?></small></td>
                            <td class="text-right"><small><?= substr($a['updateTime'], 2, -3) ?></small></td>
                            <td class="text-right">Rp<?= number_format($a['price_sell']) ?> <small>(<?= number_format($a['price_master']) ?>)</small><br><small><b><?= empty($a['message']) ? "PROCESS" : $a['message'] ?></b></small></td>
                            <td></td>
                        </tr>
                    </table>
                    <b><span class="text-success"><?= $a['sn'] ?></span></b>
                </div>
            <?php } ?>
            <span class="d-none" id="tr_antri_pre"><?= $antri_pre_count ?></span>
            <span class="d-none" id="tr_proses_pre"><?= $proses_pre_count ?></span>
        </div>
    </div>
</div>
<hr>
<span class="ml-3"><b>PASCA BAYAR</b></span>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <?php
            $no = 0;
            $antri_pre_count = 0;
            $proses_pre_count = 0;
            foreach ($data['data_post'] as $a) {
                $no++;
                if ($no > 5) {
                    break;
                }
            ?>
                <div class="col-md-12 border pb-1">
                    <table class="table table-borderless table-sm mb-0 pb-0">
                        <tr>
                            <td><small>#<?= $a['tr_id'] ?><br><?= $a['no_user'] ?></small></td>
                            <td><?= $a['customer_id'] ?><br><small><?= $a['product_code'] ?></small></td>
                            <td class="text-right"><small><?= $a['datetime'] ?></small><br><?= $a['period'] ?></td>
                            <td class="text-right">Rp<?= number_format($a['price_sell']) ?> <small>(<?= number_format($a['price']) ?>)</small><br><small><b><?= empty($a['message']) ? "PROCESS" : $a['message'] ?></b></small></td>
                        </tr>
                    </table>
                    <b><span class="text-success"><?= $a['noref'] ?></span></b>
                </div>
            <?php } ?>
        </div>
    </div>
</div>