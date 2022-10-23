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
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <?php
            $antri_pre_count = 0;
            $proses_pre_count = 0;
            foreach ($data['data_pre'] as $a) {
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
                            <td>User:<br><small><?= $a['no_user'] ?></small></td>
                            <td><?= $a['customer_id'] ?><br><small><?= $a['description'] ?></small></td>
                            <td><small>#<?= $a['tr_id'] ?><br><?= substr($a['updateTime'], 2, -3) ?></small></td>
                            <td>Rp<?= number_format($a['price_sell']) ?><br><small><b><?= empty($a['message']) ? "PROCESS" : $a['message'] ?></b></small></td>
                            <td></td>
                        </tr>
                    </table>
                    <b><span class="text-danger"><?= $a['sn'] ?></span></b>
                </div>
            <?php } ?>
            <span class="d-none" id="tr_antri_pre"><?= $antri_pre_count ?></span>
            <span class="d-none" id="tr_proses_pre"><?= $proses_pre_count ?></span>
        </div>
    </div>
</div>