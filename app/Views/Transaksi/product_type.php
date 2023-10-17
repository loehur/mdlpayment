<?php
$class_col = "col mb-2 ps-0";
$class_btn = "btn btn-sm shadow-sm btn-outline-success w-100";
?>

<div class="content">
    <div class="container-fluid">
        <div class="row ml-1">
            <div class="col-auto ps-3">
                <h6><b>
                        <?php if ($data == 1) {
                            echo "PRABAYAR";
                        } elseif ($data == 2) {
                            echo "PASCABAYAR";
                        } else {
                            echo "MANUAL";
                        } ?>
                    </b></h6>
            </div>
        </div>
        <div class="row ps-3">
            <?php
            if ($data == 1) {
                foreach ($this->prepaidList['product_type'] as $a) { ?>
                    <div class="<?= $class_col ?>">
                        <a class="<?= $class_btn ?>" href="<?= $this->BASE_URL ?>Transaksi/product_des/ <?= $a ?>/<?= $data ?>"><?= strtoupper($a) ?></a>
                    </div>
                <?php  }
            } else if ($data == 2) {
                foreach ($this->postpaidList['product_type'] as $a) { ?>
                    <div class="<?= $class_col ?>">
                        <a class="<?= $class_btn ?>" href="<?= $this->BASE_URL ?>Transaksi/product_des/ <?= $a ?>/<?= $data ?>"><?= strtoupper($a) ?></a>
                    </div>
                    <?php }
            } else {
                $manual = $this->model("M_DB_1")->get("manual_jenis");
                $harga = $this->model("M_DB_1")->get_where("manual_set", "no_master = '" . $this->userData['no_master'] . "'");
                foreach ($manual as $a) {
                    foreach ($harga as $h) {
                        if ($h['id_manual_jenis'] == $a['id_manual_jenis']) { ?>
                            <div class="<?= $class_col ?> text-nowrap">
                                <a class="<?= $class_btn ?>" href="<?= $this->BASE_URL ?>Transaksi/confirmation_manual/<?= $a['id_manual_jenis'] ?>"><?= strtoupper($a['manual_jenis']) ?></a>
                            </div>
                    <?php }
                    }
                    ?>
            <?php }
            } ?>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/selectize.min.js"></script>

<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });
</script>