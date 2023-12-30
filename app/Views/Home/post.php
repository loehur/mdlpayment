<?php
$no = 0;
$proses_post_count = 0;

$whereLabel = "user_no = '" . $this->userData['no_user'] . "' AND master_no = '" . $this->userData['no_master'] . "'";
$dtLabel = $this->model("M_DB_1")->get_where("label", $whereLabel);

$whereLabel_M = "user_no <> '" . $this->userData['no_user'] . "' AND master_no = '" . $this->userData['no_master'] . "'";
$dtLabel_M = $this->model("M_DB_1")->get_where("label", $whereLabel_M);

foreach ($data['data_post'] as $a) {

    if ($a['no_user'] <> $this->userData['no_user'] && $this->userData['user_tipe'] <> 1) {
        continue;
    }

    $id = $a['id'];
    $no++;
    if ($no > 12) {
        break;
    }
    if ($a['rc'] == "39") {
        $proses_post_count += 1;
    }
    if ($a['tr_status'] == 4 || $a['tr_status'] == 3) {
        $proses_post_count += 1;
    }

    if ($a['tr_status'] == 0 && strlen($a['noref'] > 0)) {
        $proses_post_count += 1;
    }
?>
    <div class="col border border-top-0 border-start-0 shadow-sm pb-1 rounded m-1 px-1 <?= (date("Y-m-d") == substr($a['insertTime'], 0, 10)) ? "border-secondary" : "" ?>">
        <table class="table table-borderless table-sm mb-0 pb-0">
            <tr>
                <td nowrap>
                    <?php if ($a['tr_status'] == 1 || strlen($a['noref'] > 0) || strlen($a['datetime'] > 0)) { ?>
                        <a href="" class="noact text-primary" onclick="Print('<?= $id ?>')"><i class="fas fa-print"></i></a>
                    <?php } ?>
                    <small><?= $a['insertTime'] ?><br><?= $a['no_user'] ?><br><?= $a['datetime'] ?> [<?= $a['tr_id'] ?>]</small>
                </td>
                <td class="text-end">

                    <?php if ($a['no_user'] == $this->userData['no_user']) {
                        $label = "";
                        foreach ($dtLabel as $dl) {
                            if ($dl['customer_id'] == $a['customer_id']) {
                                $label = $dl['label_name'];
                            }
                        } ?>
                        <span class="text-primary">
                            <?php if ($label == "") { ?>
                                <span class="btn btn-sm border-0 p-0" onclick="setForm('<?= $a['customer_id'] ?>','1')" data-bs-toggle="modal" data-bs-target="#exampleModal"><small><i class="fa-regular fa-bookmark text-danger"></i> Tandai</small></span>
                            <?php } else { ?>
                                <span class="btn btn-sm border-0 p-0" onclick="setForm('<?= $a['customer_id'] ?>','1')" data-bs-toggle="modal" data-bs-target="#exampleModal"><small><b class="text-primary"><i class="fa-solid fa-bookmark"></i> <?= $label ?></b></small></span>
                            <?php } ?>
                        </span>
                        <br>
                    <?php } else {
                        $label = "";
                        foreach ($dtLabel_M as $dlm) {
                            if ($dlm['customer_id'] == $a['customer_id']) {
                                $label = $dl['label_name'];
                            }
                        } ?>
                        <?php if ($label <> "") { ?>
                            <small><i class="fa-solid fa-bookmark"></i> <?= $label ?></small>
                            <br>
                        <?php } ?>
                    <?php } ?>

                    <?= $a['customer_id'] ?>
                    <br>Rp<?= number_format($a['price_sell']) ?> <?= ($this->setting['v_price'] == 1) ? "<small>(" . number_format($a['price']) . ")</small>" : "" ?>
                    <br><small class="text-nowrap"><b><?= $a['rc'] ?> - <?= empty($a['message']) ? "PROCESS" : $a['message'] ?></b></small>
                </td>
            </tr>
            <tr>
                <td align="right" colspan="2"><small><?= $a['product_code'] ?>, <b><?= $a['tr_name'] ?></b>, <?= $a['period'] ?></small><br>
                    <span class="text-success"><?= $a['noref'] ?></span>
                </td>
            </tr>
            <?php if ($a['tr_status'] == 1 || strlen($a['noref'] > 0) || strlen($a['datetime'] > 0)) { ?>
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
                                    <td>Name</td>
                                    <td>:</td>
                                    <td><?= $a['tr_name'] ?></td>
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
                                    <td colspan="3" style="text-align: center; padding-left:5mm; padding-right:5mm">
                                        No. Ref<br>
                                        <b><?= substr($a['noref'], 0, 25) . " " . substr($a['noref'], 25) ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <hr>
                                        <br>.<br>.<br>.<br>.
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

<script type="text/javascript" src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script type="text/javascript" src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
<script>
    var proses_post_count;
    $(document).ready(function() {
        proses_post_count = $("span#tr_proses_post").html();
        $("span#post_antri").html(proses_post_count);
    });