<?php
$jenis = $data['id_manual_jenis'];
$tr_status = $data['tr_status'];
$id = $data['id_manual'];
$tele_id = $data['telegram_id'];
$wa_token = $data['wa_token'];

$transaksi = "";
$manual = $this->model("M_DB_1")->get("manual_jenis");
foreach ($manual as $m) {
    if ($m['id_manual_jenis'] == $jenis) {
        $transaksi = strtoupper($m['manual_jenis']);
    }
}

$status = "";
$class_status = "";
switch ($tr_status) {
    case 0:
        $status = "Menunggu Operator";
        $class_status = "text-warning";
        break;
    case 1:
        $status = "Dalam Proses";
        $class_status = "text-info";
        break;
    case 2:
        $status = "Transaksi Sukses";
        $class_status = "text-success";
        break;
    case 3:
        $status = "Transaksi Ditolak";
        $class_status = "text-danger";
        break;
}

?>
<div class="content mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col px-4 py-3 rounded mx-4">
                <div class="row">
                    <div class="col">
                        <b><span class="text-primary"><?= $transaksi ?></span></b>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <table>
                            <tr>
                                <td><small>Trx. ID</small></td>
                                <td class="pe-1">:</td>
                                <td><span class="text-dark"><small><?= $data['id_manual'] ?></small></span></td>
                            </tr>
                            <tr>
                                <td>Tujuan</td>
                                <td class="pe-1">:</td>
                                <td><b><span class="text-dark"><?= $data['target'] ?></span></b></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td class="pe-1">:</td>
                                <td><b><span class="text-dark"><?= strtoupper($data['target_name']) ?></span></b></td>
                            </tr>
                            <tr>
                                <td>Nomor</td>
                                <td class="pe-1">:</td>
                                <td><span class="text-dark"><?= $data['target_number'] ?></span></td>
                            </tr>
                            <tr>
                                <td class="pe-2">Jumlah</td>
                                <td class="pe-1">:</td>
                                <td><span class="text-dark"><b>Rp<?= number_format($data['jumlah']) ?></b></span></td>
                            </tr>
                            <tr>
                                <td class="pe-2">Biaya Admin</td>
                                <td class="pe-1">:</td>
                                <td><span class="text-dark">Rp<?= number_format($data['biaya']) ?></span></td>
                            </tr>
                            <tr>
                                <td class="pe-2">Catatan</td>
                                <td class="pe-1">:</td>
                                <td><span class="text-danger"><i><?= $data['note'] ?></i></span></td>
                            </tr>
                            <tr>
                                <td class="pe-2">Tanggal</td>
                                <td class="pe-1">:</td>
                                <td><?= $data['insertTime'] ?></td>
                            </tr>
                            <tr>
                                <td class="pe-2">Status</td>
                                <td class="pe-1">:</td>
                                <td><b><span class="<?= $class_status ?>"><?= strtoupper($status) ?></span></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php if ($tr_status == 1) { ?>
                    <div class="row mt-2">
                        <div class="col ps-0 text-center">
                            <span class="text-secondary">Nomor/ID</span><br>
                            <input class="btn btn-outline-primary copy" value="<?= $data['target_number'] ?>" readonly />
                        </div>
                        <div class="col ps-0 text-center">
                            <span class="text-secondary">Jumlah</span><br>
                            <input class="btn btn-outline-primary copy" value="<?= $data['jumlah'] ?>" readonly />
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php
        if ($tr_status == 1) { ?>
            <div class="row px-4">
                <div class="col px-4 mx-4">
                    <div class="row mt-2">
                        <div class="col">
                            <a href="<?= $this->BASE_URL ?>O/action/<?= $id ?>/3/<?= $tele_id ?>/<?= $wa_token ?>" style="text-decoration: none;"><span class="text-danger">TOLAK</span></a>
                        </div>
                        <div class="col">
                            <a href="<?= $this->BASE_URL ?>O/action/<?= $id ?>/2/<?= $tele_id ?>/<?= $wa_token ?>"><span class="btn btn-success float-end">SUKSES</span></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
        if ($tr_status == 0) { ?>
            <div class="row px-4">
                <div class="col px-4 text-center w-100">
                    <div class="row mt-2">
                        <div class="col pe-0">
                            <a href="<?= $this->BASE_URL ?>O/action/<?= $id ?>/1/<?= $tele_id ?>/<?= $wa_token ?>"><span class="btn btn-outline-primary">PROSES</span></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- SCRIPT -->
<script>
    $("a").click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        $.ajax({
            url: href,
            type: 'POST',
            data: {},
            success: function(res) {
                content('<?= $id ?>');
            }
        });

    })

    $("input.copy").click(function() {
        var textToCopy = $(this).val();
        $(this).select();
        document.execCommand('copy');
        $(this).fadeOut(500);
        $(this).fadeIn(500);
    })
</script>