<div class="content">
    <div class="container-fluid">
        <div class="row ml-1">
            <div class="col-auto">
                <h6><b><?= ($data == 1) ? "PRABAYAR" : "PASCABAYAR"; ?></b></h6>
            </div>
        </div>
        <div class="row ml-1">
            <?php
            if ($data == 1) {
                foreach ($this->prepaidList['product_type'] as $a) { ?>
                    <div class="col-auto pb-1 pt-1 pr-2 pl-2 mr-2 mb-2 border border-success rounded">
                        <a class="text-decoration-none" href="<?= $this->BASE_URL ?>Transaksi/product_des/ <?= $a ?>/<?= $data ?>"><?= strtoupper($a) ?></a>
                    </div>
                <?php  }
            } else {
                foreach ($this->postpaidList['product_type'] as $a) { ?>
                    <div class="col-auto pb-1 pt-1 pr-2 pl-2 mr-2 mb-2 border border-success rounded">
                        <a class="text-decoration-none" href="<?= $this->BASE_URL ?>Transaksi/product_des/ <?= $a ?>/<?= $data ?>"><?= strtoupper($a) ?></a>
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