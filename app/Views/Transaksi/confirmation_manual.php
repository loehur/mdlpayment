<div class="content mt-2 mb-0 pb-0">
    <div class="container-fluid">
        <div class="row pb-0 mb-0">
            <div class="col-auto">
                <div id="info"></div>
            </div>
        </div>
    </div>
</div>

<?php
$harga = $this->model("M_DB_1")->get_where_row("manual_set", "no_master = '" . $this->userData['no_master'] . "' AND id_manual_jenis = " . $data);
?>

<div class="content mb-2 mt-0 pt-0" style="padding-bottom: 70px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto">
                <h6><b><?= $this->model("M_DB_1")->get_where_row("manual_jenis", "id_manual_jenis = " . $data)['manual_jenis'] ?></b></h6>
            </div>
        </div>
        <div class="row">
            <div class="col pe-2" style="max-width: 300px;">
                <form action="<?= $this->BASE_URL ?>Transaksi/proses_manual/<?= $data ?>" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <label class="form-label mb-1 ps-2 text-secondary">Pilih Tujuan</label>
                            <select name="target_id" id="selectTarget" class="tize border-top-0 border-end-0 border-start-0 ci_n" aria-label=".form-select-sm example" required>
                                <option class="text-secondary" selected></option>
                                <?php
                                switch ($data) {
                                    case 1:
                                    case 3:
                                    case 5:
                                        $tujuan = $this->model("M_DB_1")->get_order("_bank", "sort DESC");
                                        break;
                                    case 2:
                                    case 4:
                                        $tujuan = $this->model("M_DB_1")->get_order("_ewallet", "sort DESC");
                                        break;
                                }

                                foreach ($tujuan as $t) { ?>
                                    <option value="<?= $t['code'] ?>"><?= $t['name'] ?></option>
                                <?php

                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control form-control-sm border-top-0 border-end-0 border-start-0 ci_n" autocomplete="off" name="target_number" placeholder="Nomor/ID" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control form-control-sm border-top-0 border-end-0 border-start-0 ci_n" style="text-transform:uppercase" autocomplete="off" name="target_name" placeholder="Nama Tujuan" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="number" class="form-control form-control-sm border-top-0 border-end-0 border-start-0 ci_n" autocomplete="off" name="jumlah" placeholder="Jumlah" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mb-2 mt-3">
                        <div class="col">
                            <label class="form-label mb-0 pb-0 ps-2 text-secondary">Biaya</label>
                            <input type="number" style="pointer-events: none;" class="form-control form-control-sm border-top-0 border-end-0 pt-0 border-start-0 ci_n" value="<?= $harga['biaya_dasar'] ?>" autocomplete="off" name="biaya" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" maxlength="18" class="form-control form-control-sm border-top-0 border-end-0 border-start-0 ci_n" value="" autocomplete="off" name="note" placeholder="Catatan (Opsional)">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col ps-4">
                            <input class="form-check-input" name="partner" type="checkbox" value="1" id="partner">
                            <label class="form-check-label">
                                Partner
                            </label>
                        </div>
                    </div>
                    <div class="form-check">
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control form-control-sm border-top-0 border-end-0 border-start-0" name="pin" placeholder="PIN Transaksi" autocomplete="new-password" required>
                        </div>
                    </div>
                    <div class="row mb-2 mt-3 ps-1">
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-outline-primary btn-block">
                                Proses
                            </button>
                        </div>
                        <div class="col">
                            <span class="loader loader1"></span>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-auto ps-2 rounded border-start">
                <label class="pb-1">Frequent Accounts</label><br>
                <?php
                $cols = "target_id, target, target_name, target_number";
                $where = "id_manual_jenis = " . $data . " GROUP BY target_id, target, target_name, target_number ORDER BY id_manual DESC LIMIT 12";
                $freq = $this->model("M_DB_1")->get_cols_where("manual", $cols, $where, 1);
                foreach ($freq as $f) { ?>
                    <div style="cursor:pointer" class="freq border rounded px-1" data-id="<?= $f['target_id']  ?>" data-name="<?= $f['target_name'] ?>" data-number="<?= $f['target_number'] ?>"><?= "<span class='text-success'>" . $f['target'] . "</span> <b>" . strtoupper($f['target_name']) . "</b> " . $f['target_number'] ?></div>
                    <hr class="border-0 p-0 m-1">
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/selectize.min.js"></script>



<script>
    $(document).ready(function() {
        $("#info").hide();
        $(".loader1").hide();
        $(".loader2").hide();
        $('select#selectTarget').selectize();
        $("form").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: $(this).attr("method"),
                beforeSend: function() {
                    $("button[type=submit]").hide();
                    $(".loader1").show();
                },
                success: function(response) {
                    if (response == 0) {
                        window.location.href = "<?= $this->BASE_URL ?>Home";
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger mb-3 mt-1 py-1 px5" role="alert">' + response + '</div>')
                    }
                },
                complete: function() {
                    $("button[type=submit]").show();
                    $(".loader1").hide();
                }
            });
        });
    });

    $("input[name=jumlah]").on("keyup change", function() {
        f_biaya();
    })

    $("#partner").change(function() {
        f_biaya();
    });

    function f_biaya() {
        var tarif = <?= $harga['biaya'] ?>;
        var kelipatan = <?= $harga['kelipatan'] ?>;
        var jumlah = $("input[name=jumlah]").val();
        var biaya_dasar = <?= $harga['biaya_dasar'] ?>;
        if (jumlah >= kelipatan) {
            var pengali = Math.ceil(jumlah / kelipatan);
            biaya = biaya_dasar + (tarif * pengali);
        } else {
            biaya = biaya_dasar;
        }

        if ($('input#partner').is(':checked')) {
            biaya -= 2000;
        }

        $("input[name=biaya]").val(biaya);
    }

    $(".freq").click(function() {
        var id = $(this).attr("data-id");
        var name = $(this).attr("data-name");
        var number = $(this).attr("data-number");
        $('#selectTarget').data('selectize').setValue(id);
        $("input[name=target_name]").val(name);
        $("input[name=target_number]").val(number);
    })
</script>