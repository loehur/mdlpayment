<?php
$antri_manual_count = 0;
foreach ($data as $a) {
    $id = $a['id_manual'];
    $tr_status = $a['tr_status'];
    if ($a['tr_status'] == 0 || $a['tr_status'] == 1) {
        $antri_manual_count += 1;
    }

    $jenis = $a['id_manual_jenis'];
    if ($jenis == 3 || $jenis == 4) {
        $total = $a['jumlah'] - $a['biaya'];
    } else {
        $total = $a['jumlah'] + $a['biaya'];
    }

    $status = "";
    $class_status = "";
    switch ($tr_status) {
        case 0:
            $status = "Menunggu Operator";
            $class_status = "warning";
            break;
        case 1:
            $status = "Dalam Proses";
            $class_status = "info";
            break;
        case 2:
            $status = "Transaksi Sukses";
            $class_status = "success";
            break;
        case 3:
            $status = "Transaksi Ditolak";
            $class_status = "danger";
            break;
    }

    $transaksi = "";
    $manual = $this->model("M_DB_1")->get("manual_jenis");
    foreach ($manual as $m) {
        if ($m['id_manual_jenis'] == $jenis) {
            $transaksi = ucwords($m['manual_jenis']);
        }
    }

    $target = $a['target'];
    $target_number = $a['target_number'];
    $target_name = $a['target_name'];
    $jumlah = $a['jumlah'];
    $biaya = $a['biaya'];
?>
    <div class="col border border-top-0 border-start-0 shadow-sm pb-1 rounded m-1 px-1 <?= (date("Y-m-d") == substr($a['updateTime'], 0, 10)) ? "border-secondary" : "" ?>">
        <table class="table table-borderless table-sm mb-0 pb-0">
            <tr>
                <td nowrap>
                    <span class="text-dark"><b><?= $transaksi ?></b></span><br>
                    <?php if ($a['tr_status'] == 2) { ?>
                        <a href="" class="noact noact text-primary" onclick="Print('<?= $id ?>')"><i class="fas fa-print"></i></a>
                    <?php } ?>
                    <small> #</small><?= $id ?><br>
                    <?= $a['no_user'] ?><br>
                    <small><?= $a['insertTime'] ?></small><br>
                    <small><?= $a['updateTime'] ?></small>
                    <br><small><span class="text-<?= $class_status ?> border border-<?= $class_status ?> rounded px-2"><?= $status ?></span></small>

                </td>
                <td class="text-end">
                    <b><span><?= strtoupper($target) ?></span></b><br>
                    <span class="text-nowrap"><?= strtoupper($target_name) ?></span><br>
                    <span><?= $target_number ?></span><br>
                    <small>Jumlah</small> Rp<?= number_format($jumlah) ?><br>
                    <small>Biaya</small> Rp<?= number_format($biaya) ?><br>
                    <b>Rp<?= number_format($total) ?></b>
                    <br><span class="text-danger text-nowrap"><small><?= $a['note'] ?></small></span>
                </td>
            </tr>
            <?php if ($a['tr_status'] == 2) { ?>
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
                                    <td><?= $id ?></td>
                                </tr>
                                <tr>
                                    <td>Datetime</td>
                                    <td>:</td>
                                    <td><?= $a['updateTime'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>Status</b></td>
                                    <td><b>:</b></td>
                                    <td><b><?= strtoupper($status) ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Product</td>
                                    <td>:</td>
                                    <td><?= $transaksi ?></td>
                                </tr>
                                <tr>
                                    <td>Tujuan</td>
                                    <td>:</td>
                                    <td><?= $target ?></td>
                                </tr>
                                <tr>
                                    <td>Nomor/ID</td>
                                    <td>:</td>
                                    <td><?= $target_number ?></td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td><?= strtoupper($target_name) ?></td>
                                </tr>
                                <tr>
                                    <td>Jumlah</td>
                                    <td>:</td>
                                    <td>Rp<?= number_format($jumlah) ?></td>
                                </tr>
                                <tr>
                                    <td>Biaya</td>
                                    <td>:</td>
                                    <td>Rp<?= number_format($biaya) ?></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>:</td>
                                    <td>Rp<?= number_format($total) ?></td>
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
                                        Trx#<?= $id ?>
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

<span class="d-none" id="tr_antri_manual"><?= $antri_manual_count ?></span>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
<script>
    var antri_manual_count;
    $(document).ready(function() {
        antri_manual_count = $("span#tr_antri_manual").html();
        $("span#manual_antri").html(antri_manual_count);
    });
</script>