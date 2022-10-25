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
                $id = $a['id'];
                $rc = $a['rc'];
                $tr_status = $a['tr_status'];
                $no++;
                if ($no > 6) {
                    break;
                }
                if (($a['tr_status'] == 0) && strlen($a['rc']) == 0) {
                    $antri_pre_count += 1;
                }
                if ($a['rc'] == "39" || $a['rc'] == "201" || strlen($a['sn']) == 0) {
                    $proses_pre_count += 1;
                }
            ?>
                <div class="col-md-6 border pb-1">
                    <table class="table table-borderless table-sm mb-0 pb-0">
                        <tr>
                            <td> <?php if ($a['tr_status'] == 1 && $rc == "00") { ?>
                                    <a href="" class="noact badge btn btn-outline-primary pt-1" onclick="Print('<?= $id ?>')"><i class="fas fa-print"></i></a>
                                <?php } ?>
                                <small>#<?= $a['tr_id'] ?><br><?= $a['no_user'] ?><br><?= substr($a['updateTime'], 2, -3) ?></small>
                            </td>
                            <td class="text-right">
                                <span class="text-info"><?= $a['customer_id'] ?></span><br>
                                Rp<?= number_format($a['price_sell']) ?> <?= ($this->setting['v_price'] == 1) ? "<small>(" . number_format($a['price_master']) . ")</small>" : "" ?><br><small><b><?= empty($a['message']) ? "PROCESS" : $a['message'] ?></b></small>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="3"><small><?= $a['description'] ?></small><br>
                                <b><span class="text-success"><?= $a['sn'] ?></span></b>
                            </td>
                        </tr>
                        <?php if ($a['tr_status'] == 1 && $rc == "00") { ?>
                            <tr class="d-none">
                                <td colspan="10">
                                    <div class="d-none" id="print<?= $id ?>" style="width:50mm;background-color:white; border:1px solid grey">
                                        <style>
                                            html .table {
                                                font-family: 'Titillium Web', sans-serif;
                                            }

                                            html .content {
                                                font-family: 'Titillium Web', sans-serif;
                                            }

                                            html body {
                                                font-family: 'Titillium Web', sans-serif;
                                            }

                                            hr {
                                                border-top: 1px dashed black;
                                            }

                                            td {
                                                vertical-align: top;
                                            }
                                        </style>
                                        <table style="width:42mm; font-size:x-small; margin-top:10px; margin-bottom:10px">
                                            <tr>
                                                <td colspan="3" style="text-align: center; padding:6px;">
                                                    <b> <?= strtoupper($this->setting['nama']) ?> [ <?= $this->userData['id_user'] ?> ]</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Trx. ID</td>
                                                <td>:</td>
                                                <td><?= $a['tr_id'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Datetime</td>
                                                <td>:</td>
                                                <td><?= $a['updateTime'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Status:</b></td>
                                                <td><b>:</b></td>
                                                <td><b><?= $a['message'] ?></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Number</td>
                                                <td>:</td>
                                                <td><?= $a['customer_id'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Product</td>
                                                <td>:</td>
                                                <td><?= $a['description'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Price</td>
                                                <td>:</td>
                                                <td>Rp<?= number_format($a['price_sell']) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: center;">SN<br><b><?= $a['sn'] ?></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                    <br>.
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
            <span class="d-none" id="tr_antri_pre"><?= $antri_pre_count ?></span>
            <span class="d-none" id="tr_proses_pre"><?= $proses_pre_count ?></span>
        </div>
    </div>
</div>
<hr>
<span class="ml-3"><b>PASCA BAYAR</b></span>
<div class="content" style="padding-bottom: 70px;">
    <div class="container-fluid">
        <div class="row">
            <?php
            $no = 0;
            $proses_post_count = 0;
            foreach ($data['data_post'] as $a) {
                $id = $a['id'];
                $no++;
                if ($no > 6) {
                    break;
                }
                if ($a['tr_status'] == 4 || $a['tr_status'] == 3) {
                    $proses_post_count += 1;
                }
            ?>
                <div class="col-md-6 border pb-1">
                    <table class="table table-borderless table-sm mb-0 pb-0">
                        <tr>
                            <td>
                                <?php if ($a['tr_status'] == 1) { ?>
                                    <a href="" class="noact badge btn btn-outline-primary pt-1" onclick="Print('<?= $id ?>')"><i class="fas fa-print"></i></a>
                                <?php } ?>
                                <small>#<?= $a['tr_id'] ?><br><?= $a['no_user'] ?><br><?= $a['datetime'] ?></small>
                            </td>
                            <td class="text-right"><span class="text-info"><?= $a['customer_id'] ?></span><br>Rp<?= number_format($a['price_sell']) ?> <?= ($this->setting['v_price'] == 1) ? "<small>(" . number_format($a['price']) . ")</small>" : "" ?><br><small><b><?= empty($a['message']) ? "PROCESS" : $a['message'] ?></b></small></td>
                        </tr>
                        <tr>
                            <td align="right" colspan="2"><small><?= $a['product_code'] ?>, <b><?= $a['tr_name'] ?></b>, <?= $a['period'] ?></small><br>
                                <b><span class="text-success"><?= $a['noref'] ?></span></b>
                            </td>
                        </tr>
                        <?php if ($a['tr_status'] == 1) { ?>
                            <tr class="d-none">
                                <td colspan="10">
                                    <div class="d-none" id="print<?= $id ?>" style="width:50mm;background-color:white; border:1px solid grey">
                                        <style>
                                            html .table {
                                                font-family: 'Titillium Web', sans-serif;
                                            }

                                            html .content {
                                                font-family: 'Titillium Web', sans-serif;
                                            }

                                            html body {
                                                font-family: 'Titillium Web', sans-serif;
                                            }

                                            hr {
                                                border-top: 1px dashed black;
                                            }

                                            td {
                                                vertical-align: top;
                                            }
                                        </style>
                                        <table style="width:42mm; font-size:x-small; margin-top:10px; margin-bottom:10px">
                                            <tr>
                                                <td colspan="3" style="text-align: center; padding:6px;">
                                                    <b> <?= strtoupper($this->setting['nama']) ?> [ <?= $this->userData['id_user'] ?> ]</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Trx. ID</td>
                                                <td>:</td>
                                                <td><?= $a['tr_id'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Datetime</td>
                                                <td>:</td>
                                                <td><?= $a['updateTime'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Status:</b></td>
                                                <td><b>:</b></td>
                                                <td><b><?= $a['message'] ?></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Number</td>
                                                <td>:</td>
                                                <td><?= $a['customer_id'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Product</td>
                                                <td>:</td>
                                                <td><?= $a['product_code'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Period</td>
                                                <td>:</td>
                                                <td><?= $a['period'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Nominal</td>
                                                <td>:</td>
                                                <td>Rp<?= number_format($a['nominal']) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Server</td>
                                                <td>:</td>
                                                <td>Rp<?= number_format($a['admin']) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Counter</td>
                                                <td>:</td>
                                                <td>Rp<?= number_format($a['price_sell'] - $a['price']) ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>:</b></td>
                                                <td><b>Rp<?= number_format($a['price_sell']) ?></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: center;">No. Ref<br><small><?= substr($a['noref'], 0, 25) . " " . substr($a['noref'], 25) ?></small></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                    <br>.
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
            <span class="d-none" id="tr_proses_post"><?= $proses_post_count ?></span>
        </div>
    </div>
</div>