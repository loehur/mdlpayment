<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto me-auto">
                Outlate/Staff
                <h6><b class="text-success"><?= ($this->userData['nama'] == $this->setting['nama']) ? $this->setting['nama'] : $this->setting['nama'] . "/" . $this->userData['nama']; ?></b></h6>
            </div>
            <div class="col-auto">
                <span class="float-right">Kas</span><br>
                <h6><b class="text-success"><?= number_format($data['kas']) ?></b></h6>
            </div>
            <?php if ($this->userData['no_user'] == $this->userData['no_master']) { ?>
                <div class="col-auto">
                    <span class="float-right">Saldo</span><br>
                    <h6><b class="text-success"><?= number_format($data['saldo']) ?></b></h6>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<ul class="nav nav-tabs mx-2 mt-2" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Pra Bayar [<span id="pre_antri"></span>]</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Pasca Bayar [<span id="post_antri"></span>]</button>
    </li>
</ul>
<div class="tab-content mx-2 border border-top-0" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
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
                        <div class="col-md-6 border border-white border-3 pb-1 rounded" style="background-color:aliceblue;">
                            <table class="table table-borderless table-sm mb-0 pb-0">
                                <tr>
                                    <td nowrap> <?php if ($a['tr_status'] == 1 && $rc == "00") { ?>
                                            <a href="" class="noact noact text-primary" onclick="Print('<?= $id ?>')"><i class="fas fa-print"></i></a>
                                        <?php } ?>
                                        <small><?= $a['insertTime'] ?><br><?= $a['no_user'] ?><br><?= substr($a['updateTime'], 2, -3) ?> [<?= $a['tr_id'] ?>]</small>
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
                    <span class="d-none" id="tr_antri_pre"><?= $antri_pre_count ?></span>
                    <span class="d-none" id="tr_proses_pre"><?= $proses_pre_count ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $no = 0;
                    $proses_post_count = 0;
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
                        <div class="col-md-6 border border-white border-3 pb-1 rounded" style="background-color:blanchedalmond">
                            <table class="table table-borderless table-sm mb-0 pb-0">
                                <tr>
                                    <td nowrap>
                                        <?php if ($a['tr_status'] == 1 || strlen($a['noref'] > 0) || strlen($a['datetime'] > 0)) { ?>
                                            <a href="" class="noact text-primary" onclick="Print('<?= $id ?>')"><i class="fas fa-print"></i></a>
                                        <?php } ?>
                                        <small><?= $a['insertTime'] ?><br><?= $a['no_user'] ?><br><?= $a['datetime'] ?> [<?= $a['tr_id'] ?>]</small>
                                    </td>
                                    <td class="text-end"><span class="text-info"><?= $a['customer_id'] ?></span><br>Rp<?= number_format($a['price_sell']) ?> <?= ($this->setting['v_price'] == 1) ? "<small>(" . number_format($a['price']) . ")</small>" : "" ?><br><small><b>[<?= $a['rc'] ?>] <?= empty($a['message']) ? "PROCESS" : $a['message'] ?></b></small></td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="2"><small><?= $a['product_code'] ?>, <b><?= $a['tr_name'] ?></b>, <?= $a['period'] ?></small><br>
                                        <b><span class="text-success"><?= $a['noref'] ?></span></b>
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
                                                        <td colspan="3" style="text-align: center;">No. Ref<br><small><?= substr($a['noref'], 0, 25) . " " . substr($a['noref'], 25) ?></small></td>
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
                </div>
            </div>
        </div>
    </div>
</div>


<div class="content" style="padding-bottom:80px">
    <div class="container-fluid">
    </div>
</div>

<script type="text/javascript" src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script type="text/javascript" src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
<script>
    var antri_pre_count;
    var proses_pre_count;
    var proses_post_count;
    $(document).ready(function() {
        antri_pre_count = $("span#tr_antri_pre").html();
        proses_pre_count = $("span#tr_proses_pre").html();
        $("span#pre_antri").html(antri_pre_count + "" + proses_pre_count);

        proses_post_count = $("span#tr_proses_post").html();
        $("span#post_antri").html(proses_post_count);
    });
</script>