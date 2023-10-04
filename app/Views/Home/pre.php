<?php
$no = 0;
$antri_pre_count = 0;
$proses_pre_count = 0;
foreach ($data['data_pre'] as $a) {

    if ($a['no_user'] <> $this->userData['no_user'] && $this->userData['user_tipe'] <> 1) {
        continue;
    }


    $id = $a['id'];
    $rc = $a['rc'];
    $tr_status = $a['tr_status'];
    $no++;
    if ($no > 12) {
        break;
    }
    if (strlen($a['rc']) == 0 || $a['rc'] == "06") {
        $antri_pre_count += 1;
    }
    if (($a['tr_status'] == 0 && ($a['rc'] == "39" || $a['rc'] == "201" || strlen($a['sn']) == 0)) || ($a['tr_status'] == 1 && strlen($a['sn']) == 0)) {
        $proses_pre_count += 1;
    } elseif ($a['tr_status'] == 2 && $a['rc'] == "39") {
        $proses_pre_count += 1;
    } elseif ($a['tr_status'] == 1 && strlen($a['sn']) == 0) {
        $proses_pre_count += 1;
    }
?>
    <div class="col border pb-1 rounded m-1 px-1 <?= (date("Y-m-d") == substr($a['updateTime'], 0, 10)) ? "border-secondary" : "" ?>">
        <table class="table table-borderless table-sm mb-0 pb-0">
            <tr>
                <td nowrap> <?php if ($a['tr_status'] == 1 && $rc == "00") { ?>
                        <a href="" class="noact noact text-primary" onclick="Print('<?= $id ?>')"><i class="fas fa-print"></i></a>
                    <?php } ?>
                    <small><?= $a['insertTime'] ?> [<?= $id ?>]<br><?= $a['no_user'] ?><br><?= substr($a['updateTime'], 2, -3) ?> [<?= $a['tr_id'] ?>]</small>
                </td>
                <td class="text-end">
                    <span class="text-info"><?= $a['customer_id'] ?></span><br>
                    Rp<?= number_format($a['price_sell']) ?> <?= ($this->setting['v_price'] == 1) ? "<small>(" . number_format($a['price_master']) . ")</small>" : "" ?><br><small><b>[<?= $a['rc'] ?>] <?= empty($a['message']) ? "PROCESS" : $a['message'] ?></b></small>
                </td>
            </tr>
            <tr>
                <td align="right" colspan="2"><small><?= $a['description'] ?></small><br>
                    <?php if (strlen($a['sn'] > 0)) { ?><b><span class="text-success"><?= $a['sn'] ?></span></b><?php } else { ?>

                        <br> <?php } ?>
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
                            <table style="width:42mm; font-size:x-small; margin-top:10px;">
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
                                    <td><b>Status</b></td>
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
                            </table>
                            <table style="table-layout:fixed;width:42mm;margin-top:0">
                                <tr>
                                    <td colspan="3" style="padding-left:5mm; padding-right:5mm; text-align: center; word-wrap: break-word; font-size:11px">
                                        <b><?= $a['sn'] ?></b>
                                    </td>
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

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
<script>
    var antri_pre_count;
    var proses_pre_count;
    $(document).ready(function() {
        antri_pre_count = $("span#tr_antri_pre").html();
        proses_pre_count = $("span#tr_proses_pre").html();
        $("span#pre_antri").html(antri_pre_count + "" + proses_pre_count);
    });
</script>