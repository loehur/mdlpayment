<?php
$class_col = "col mb-2 ps-0";
$class_btn = "btn btn-sm shadow-sm btn-outline-success w-100";
?>

<div class="content">
    <div class="container-fluid">
        <div class="row ml-1">
            <div class="col-auto">
                <h6><b><?= ($data == 1) ? "PRABAYAR" : "PASCABAYAR"; ?></b></h6>
            </div>
        </div>
        <div class="row ms-1">
            <?php
            if ($data == 1) {
                foreach ($this->prepaidList['product_type'] as $a) { ?>
                    <div class="<?= $class_col ?>">
                        <a class="<?= $class_btn ?>" href="<?= $this->BASE_URL ?>Transaksi/product_des/ <?= $a ?>/<?= $data ?>"><?= strtoupper($a) ?></a>
                    </div>
                <?php  }
            } else {
                foreach ($this->postpaidList['product_type'] as $a) { ?>
                    <div class="<?= $class_col ?>">
                        <a class="<?= $class_btn ?>" href="<?= $this->BASE_URL ?>Transaksi/product_des/ <?= $a ?>/<?= $data ?>"><?= strtoupper($a) ?></a>
                    </div>
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